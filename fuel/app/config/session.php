<?php

return array(
	// セッションCookie（ログイン状態）だけはXSS対策としてJSから読めないようにする。
	// config.php の cookie.http_only は CSRFトークンCookieにも影響するため false のままにし、
	// セッションCookieだけここで個別に true を指定する。
	'cookie_http_only' => true,
);
