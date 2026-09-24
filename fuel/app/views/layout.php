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
            .app-shell{
                display:flex;
                min-height:100vh;
            }
            .sidebar{
                width:200px;
                flex-shrink:0;
                border-right:1px solid var(--border);
                padding:1rem;
            }
            .sidebar .app-name{
                font-weight:bold;
                margin-bottom:1rem;
            }
            .sidebar nav{
                display:flex;
                flex-direction:column;
                gap:0.5rem;
            }
            .sidebar nav a{
                color:var(--text);
                text-decoration:none;
                padding:0.5rem;
                border-radius:4px;
            }
            .sidebar nav a:hover{
                background:var(--border);
            }
            .main-column{
                flex:1;
                min-width:0;
            }
            table{
                width:100%;
                border-collapse:collapse;
                table-layout:fixed;
            }
            th, td{
                border:1px solid var(--border);
                padding:0.5rem;
                text-align:left;
                overflow:hidden;
                text-overflow:ellipsis;
                white-space:nowrap;
            }
            th:last-child, td:last-child{
                width:140px;
                white-space:normal;
            }
            td input, td select{
                width:100%;
                box-sizing:border-box;
            }
            .bar-chart{
                display:flex;
                align-items:flex-end;
                gap:1rem;
                height:200px;
                padding:1rem 0;
            }
            .bar-item{
                display:flex;
                flex-direction:column;
                align-items:center;
                gap:0.25rem;
            }
            .bar{
                width:32px;
                background:var(--accent);
                border-radius:4px 4px 0 0;
            }
            .bar-value{
                font-size:0.75rem;
            }
            .bar-label{
                font-size:0.75rem;
                color:var(--text);
            }



        </style>
    </head>
    <body>
        <div class = "app-shell">
            <?php if ($current_user): ?>
                <aside class = "sidebar">
                    <div class = "app-name">家計簿アプリ</div>
                    <nav>
                        <a href = "<?=\Uri::create("home")?>">ホーム</a>
                        <a href = "<?=\Uri::create("expense")?>">支出一覧</a>
                        <a href = "<?=\Uri::create("category")?>">カテゴリ管理</a>
                        <a href = "<?=\Uri::create("budget")?>">支出目標</a>
                        <a href = "<?=\Uri::create("settings")?>">設定</a>
                    </nav>
                </aside>
            <?php endif; ?>
            <div class = "main-column">
                <main>
                    <?=$content ??""?>
                </main>
            </div>
        </div>
    </body>

</html>