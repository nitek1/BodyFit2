$php = 'C:\Users\nicko\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe'
$root = 'C:\Users\nicko\OneDrive\Desktop\BK\Bodyfit1'
$config = 'C:\Users\nicko\OneDrive\Desktop\BK\bodyfit-php.ini'
$url = 'http://127.0.0.1:8096'

Set-Location $root
& $php -c $config -S 127.0.0.1:8096
