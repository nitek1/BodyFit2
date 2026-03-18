const { Client } = require('pg');

const client = new Client({
  user: 'postgres',
  host: 'localhost',
  database: 'postgres',
  password: 'admin',
  port: 5432,
});

async function connectDatabase() {
  await client.connect();
  console.log('Conectado ao PostgreSQL');
  return client;
}

async function testConnection() {
  try {
    await connectDatabase();
    const res = await client.query('SELECT NOW()');
    console.log(res.rows);
  } catch (err) {
    console.error('Erro na conexao', err);
    process.exitCode = 1;
  } finally {
    await client.end();
  }
}

module.exports = { client, connectDatabase };

if (require.main === module) {
  testConnection();
}
