<!DOCTYPE html>
<html lang="ja" data-theme="<?=$theme ?>">
    <head>
        <meta charset="UTF-8">
        <title><?= isset($title)?$title."-家計簿アプリ":"家計簿アプリ"?></title>
        <style>
            :root{
                --bg: #ffffff;
                --text: #1a1a1a;
                --accent: #2f7d6b;
                --border: #dddddd;
            }
            html[data-theme="dark"]{
                --bg: #1a1a1a;
                --text: #eeeeee;
                --accent: #4fbf9f;
                --border: #444444;           
            }
            body{
                background:var(--bg);
                color:var(--text);
                font-family:sans-serif;
                margin:0;
            }
            header{
                border-bottom:1px solid var(--border);
                padding:irem;
            }
            main{
                padding:1rem;
            }
        </style>
    </head>
    <body>
        <header>
            家計簿アプリ
            <?php if ($current_user): ?>
                ようこそ、<?=$current_user["username"]?>さん
            <?php endif; ?>
        </header>
        <main>
            <?=$content ??""?>
        </main>
    </body>
</html>