<?php

/**
 * 環境變數載入器
 * 會自動載入專案根目錄的 .env 檔案
 */
class EnvLoader
{
  private static $loaded = false;

  public static function load($path = null)
  {
    if (self::$loaded) return;
    $envFile = $path ?: __DIR__ . '/.env';
    if (!file_exists($envFile)) return;
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
      if (strpos(trim($line), '#') === 0) continue;
      if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
          (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)
        ) {
          $value = substr($value, 1, -1);
        }
        putenv("$key=$value");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
      }
    }
    self::$loaded = true;
  }

  public static function get($key, $default = null)
  {
    $value = getenv($key);
    return $value !== false ? $value : $default;
  }

  public static function has($key)
  {
    return getenv($key) !== false;
  }
}
// 自動載入
EnvLoader::load();
