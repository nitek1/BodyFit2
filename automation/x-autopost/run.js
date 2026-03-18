"use strict";

const crypto = require("node:crypto");

const HN_TOP_STORIES_URL = "https://hacker-news.firebaseio.com/v0/topstories.json";
const HN_ITEM_URL = "https://hacker-news.firebaseio.com/v0/item";
const X_CREATE_POST_URL = "https://api.x.com/2/tweets";

const REQUIRED_ENV_VARS = [
  "X_API_KEY",
  "X_API_SECRET",
  "X_ACCESS_TOKEN",
  "X_ACCESS_TOKEN_SECRET",
];

const AI_KEYWORDS = [
  "ai",
  "artificial intelligence",
  "agent",
  "agents",
  "llm",
  "gpt",
  "openai",
  "anthropic",
  "claude",
  "gemini",
  "nvidia",
  "gpu",
  "chip",
  "chips",
  "semiconductor",
  "robot",
  "robots",
  "open source",
  "open model",
  "open models",
  "weights",
  "inference",
  "training",
];

const TECH_KEYWORDS = [
  "developer",
  "startup",
  "cloud",
  "browser",
  "security",
  "research",
  "software",
  "api",
  "framework",
  "database",
  "performance",
];

async function main() {
  const dryRun = String(process.env.DRY_RUN || "false").toLowerCase() === "true";
  const forceTitle = (process.env.FORCE_TITLE || "").trim();
  const postPrefix = (process.env.POST_PREFIX || "Radar tech/IA").trim();
  const postHashtags = (process.env.POST_HASHTAGS || "#IA #Tecnologia").trim();

  const story = forceTitle ? buildForcedStory(forceTitle) : await pickStory();
  const postText = buildPostText(story, postPrefix, postHashtags);

  console.log(`Selected title: ${story.title}`);
  console.log(`Selected url: ${story.url || "n/a"}`);
  console.log(`Generated post (${postText.length} chars): ${postText}`);

  if (dryRun) {
    console.log("DRY_RUN enabled. Skipping X publish.");
    return;
  }

  validateEnv();
  const result = await publishToX(postText);
  console.log(`Posted successfully with id: ${result.data.id}`);
}

function buildForcedStory(title) {
  return {
    title,
    url: "",
    score: 999,
  };
}

async function pickStory() {
  const ids = await getJson(HN_TOP_STORIES_URL);
  const topIds = ids.slice(0, 40);
  const stories = await Promise.all(topIds.map((id) => getJson(`${HN_ITEM_URL}/${id}.json`)));

  const candidates = stories
    .filter((story) => story && story.type === "story" && story.title)
    .map((story) => ({
      ...story,
      relevance: scoreStory(story.title),
    }))
    .filter((story) => story.relevance > 0)
    .sort((a, b) => {
      if (b.relevance !== a.relevance) {
        return b.relevance - a.relevance;
      }

      return (b.score || 0) - (a.score || 0);
    });

  if (candidates.length === 0) {
    throw new Error("No relevant AI/tech story found in current Hacker News top stories.");
  }

  return candidates[0];
}

function scoreStory(title) {
  const normalized = title.toLowerCase();
  let score = 0;

  for (const keyword of AI_KEYWORDS) {
    if (normalized.includes(keyword)) {
      score += 5;
    }
  }

  for (const keyword of TECH_KEYWORDS) {
    if (normalized.includes(keyword)) {
      score += 2;
    }
  }

  if (normalized.includes("show hn")) {
    score -= 2;
  }

  return score;
}

function buildPostText(story, prefix, hashtags) {
  const shortTitle = smartTrim(cleanTitle(story.title), 110);
  const insight = chooseInsight(story.title);
  const candidates = [
    `${prefix}: "${shortTitle}". ${insight} ${hashtags}`,
    `${prefix}: ${shortTitle}. ${insight} ${hashtags}`,
    `${shortTitle}. ${insight} ${hashtags}`,
  ];

  for (const candidate of candidates) {
    if (candidate.length <= 280) {
      return candidate;
    }
  }

  const fallbackInsight = smartTrim(insight, 90);
  return smartTrim(`${prefix}: ${shortTitle}. ${fallbackInsight} ${hashtags}`, 280);
}

function cleanTitle(title) {
  return title.replace(/\s+/g, " ").replace(/[“”]/g, "\"").trim();
}

function chooseInsight(title) {
  const normalized = title.toLowerCase();

  if (includesAny(normalized, ["agent", "agents"])) {
    return "Agentes mais uteis e menos demo seguem puxando a proxima onda.";
  }

  if (includesAny(normalized, ["nvidia", "gpu", "chip", "chips", "semiconductor"])) {
    return "A disputa continua sendo infraestrutura para escalar IA no mundo real.";
  }

  if (includesAny(normalized, ["open source", "open model", "open models", "weights"])) {
    return "Open models seguem pressionando custo, velocidade e acesso.";
  }

  if (includesAny(normalized, ["security", "browser"])) {
    return "Ferramentas mais autonomas aumentam o peso de seguranca e confiabilidade.";
  }

  if (includesAny(normalized, ["gpt", "openai", "anthropic", "claude", "gemini", "llm", "ai"])) {
    return "O mercado segue premiando quem transforma modelos em produto de verdade.";
  }

  return "Tecnologia continua acelerando onde produto e execucao andam juntos.";
}

function includesAny(text, words) {
  return words.some((word) => text.includes(word));
}

function smartTrim(text, maxLength) {
  if (text.length <= maxLength) {
    return text;
  }

  const sliced = text.slice(0, maxLength - 1);
  const trimmedAtWord = sliced.slice(0, sliced.lastIndexOf(" "));
  return `${trimmedAtWord || sliced}...`;
}

async function publishToX(text) {
  const body = JSON.stringify({ text });
  const authHeader = createOAuthHeader("POST", X_CREATE_POST_URL);

  const response = await fetch(X_CREATE_POST_URL, {
    method: "POST",
    headers: {
      Authorization: authHeader,
      "Content-Type": "application/json",
    },
    body,
  });

  const payload = await response.json().catch(() => ({}));

  if (!response.ok) {
    throw new Error(`X API error ${response.status}: ${JSON.stringify(payload)}`);
  }

  return payload;
}

function createOAuthHeader(method, url) {
  const oauth = {
    oauth_consumer_key: process.env.X_API_KEY,
    oauth_nonce: crypto.randomBytes(16).toString("hex"),
    oauth_signature_method: "HMAC-SHA1",
    oauth_timestamp: String(Math.floor(Date.now() / 1000)),
    oauth_token: process.env.X_ACCESS_TOKEN,
    oauth_version: "1.0",
  };

  const signatureBase = createSignatureBaseString(method, url, oauth);
  const signingKey = `${percentEncode(process.env.X_API_SECRET)}&${percentEncode(process.env.X_ACCESS_TOKEN_SECRET)}`;
  oauth.oauth_signature = crypto
    .createHmac("sha1", signingKey)
    .update(signatureBase)
    .digest("base64");

  const headerParams = Object.keys(oauth)
    .sort()
    .map((key) => `${percentEncode(key)}="${percentEncode(oauth[key])}"`)
    .join(", ");

  return `OAuth ${headerParams}`;
}

function createSignatureBaseString(method, url, params) {
  const normalizedUrl = normalizeUrl(url);
  const normalizedParams = Object.keys(params)
    .sort()
    .map((key) => `${percentEncode(key)}=${percentEncode(params[key])}`)
    .join("&");

  return [
    method.toUpperCase(),
    percentEncode(normalizedUrl),
    percentEncode(normalizedParams),
  ].join("&");
}

function normalizeUrl(url) {
  const parsed = new URL(url);
  return `${parsed.protocol}//${parsed.host}${parsed.pathname}`;
}

function percentEncode(value) {
  return encodeURIComponent(String(value))
    .replace(/[!'()*]/g, (char) => `%${char.charCodeAt(0).toString(16).toUpperCase()}`);
}

function validateEnv() {
  const missing = REQUIRED_ENV_VARS.filter((key) => !process.env[key]);

  if (missing.length > 0) {
    throw new Error(`Missing required environment variables: ${missing.join(", ")}`);
  }
}

async function getJson(url) {
  const response = await fetch(url, {
    headers: {
      "User-Agent": "bk-x-autopost-script",
    },
  });

  if (!response.ok) {
    throw new Error(`Request failed for ${url}: ${response.status}`);
  }

  return response.json();
}

main().catch((error) => {
  console.error(error.stack || error.message || String(error));
  process.exitCode = 1;
});
