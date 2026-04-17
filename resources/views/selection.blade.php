<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiverso Battle - Character Select</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #060913;
            --hud: rgba(9, 14, 28, 0.82);
            --line: rgba(255, 255, 255, 0.18);
            --p1: #ef4444;
            --p2: #3b82f6;
            --gold: #facc15;
            --text: #ecf4ff;
            --soft: #99a8c4;
            --shadow: 0 24px 54px rgba(0, 0, 0, 0.55);
            --brightness-level: 1;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
            background: var(--bg);
            color: var(--text);
            font-family: 'Rajdhani', sans-serif;
            overflow-x: hidden;
            filter: brightness(var(--brightness-level));
        }

        body[data-theme='inferno'] {
            --bg: #16070a;
            --hud: rgba(37, 10, 10, 0.86);
            --line: rgba(255, 161, 101, 0.34);
            --p1: #ef4444;
            --p2: #f97316;
            --gold: #f59e0b;
            --text: #fff1e6;
            --soft: #f4b798;
        }

        body[data-theme='cyber'] {
            --bg: #04171b;
            --hud: rgba(2, 28, 34, 0.85);
            --line: rgba(52, 211, 153, 0.35);
            --p1: #34d399;
            --p2: #22d3ee;
            --gold: #67e8f9;
            --text: #defcff;
            --soft: #9fe0e7;
        }

        .screen {
            min-height: 100vh;
            position: relative;
            display: none;
        }

        .screen.active {
            display: block;
        }

        .fluid-canvas {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.7;
        }

        .overlay-noise {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background-image: radial-gradient(rgba(255, 255, 255, 0.03) 0.8px, transparent 0.8px);
            background-size: 3px 3px;
            mix-blend-mode: soft-light;
        }

        .settings-toggle {
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 12;
            width: 44px;
            height: 44px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: rgba(0, 0, 0, 0.48);
            color: var(--text);
            font-size: 1.3rem;
            cursor: pointer;
            display: grid;
            place-items: center;
            box-shadow: var(--shadow);
        }

        .settings-panel {
            position: fixed;
            top: 68px;
            right: 16px;
            z-index: 12;
            width: min(320px, calc(100vw - 32px));
            border: 1px solid var(--line);
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(6, 12, 23, 0.95), rgba(4, 8, 16, 0.95));
            box-shadow: var(--shadow);
            padding: 12px;
            display: none;
        }

        .settings-panel.open {
            display: block;
        }

        .settings-title {
            margin: 0 0 10px;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: 0.9rem;
            color: var(--gold);
        }

        .settings-row {
            display: grid;
            gap: 6px;
            margin-bottom: 10px;
        }

        .settings-row label {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--soft);
        }

        .settings-row input[type='range'],
        .settings-row select {
            width: 100%;
        }

        .settings-tip {
            margin: 6px 0 0;
            font-size: 0.8rem;
            color: var(--soft);
        }

        .start-wrap {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 24px;
            cursor: pointer;
        }

        .start-title {
            font-family: 'Orbitron', sans-serif;
            margin: 0;
            font-size: clamp(2.7rem, 11vw, 8.2rem);
            line-height: 0.86;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            text-shadow: 0 0 28px rgba(239, 68, 68, 0.72);
            background: linear-gradient(90deg, #ef4444, #facc15, #ef4444);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .start-sub {
            font-family: 'Orbitron', sans-serif;
            margin: 8px 0 26px;
            font-size: clamp(1.1rem, 3vw, 2.25rem);
            letter-spacing: 0.32em;
            text-transform: uppercase;
        }

        .press-start {
            display: inline-block;
            border: 2px solid var(--gold);
            border-radius: 10px;
            padding: 10px 18px;
            font-family: 'Orbitron', sans-serif;
            color: var(--gold);
            font-size: 1rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            animation: blink 1s steps(2, start) infinite;
            background: rgba(0, 0, 0, 0.45);
        }

        .start-foot {
            margin-top: 20px;
            color: var(--soft);
            font-family: 'Orbitron', sans-serif;
            font-size: 0.75rem;
            letter-spacing: 0.12em;
        }

        @keyframes blink {
            50% {
                opacity: 0.36;
            }
        }

        .select-wrap {
            position: relative;
            z-index: 2;
            width: min(1600px, 96vw);
            margin: 0 auto;
            padding: 14px 0 16px;
            display: grid;
            gap: 12px;
        }

        .header {
            background: var(--hud);
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: var(--shadow);
            text-align: center;
            padding: 12px;
        }

        .header h2 {
            margin: 0;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: clamp(1.15rem, 3.2vw, 2.6rem);
        }

        .header .p1 {
            color: var(--p1);
            text-shadow: 0 0 12px rgba(239, 68, 68, 0.8);
        }

        .header .p2 {
            color: var(--p2);
            text-shadow: 0 0 12px rgba(59, 130, 246, 0.8);
        }

        .header .done {
            color: var(--gold);
            text-shadow: 0 0 12px rgba(250, 204, 21, 0.8);
        }

        .arena {
            display: grid;
            grid-template-columns: 1fr 1.35fr 1fr;
            gap: 10px;
            min-height: 76vh;
        }

        .panel {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: linear-gradient(180deg, rgba(14, 20, 37, 0.92), rgba(8, 12, 22, 0.88));
            overflow: hidden;
            box-shadow: var(--shadow);
            position: relative;
        }

        .panel.active-p1 {
            border-color: rgba(239, 68, 68, 0.6);
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.25), var(--shadow);
        }

        .panel.active-p2 {
            border-color: rgba(59, 130, 246, 0.65);
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25), var(--shadow);
        }

        .tag {
            position: absolute;
            top: 0;
            padding: 6px 12px;
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #fff;
            z-index: 3;
        }

        .tag.p1 {
            left: 0;
            background: rgba(239, 68, 68, 0.9);
            border-bottom-right-radius: 10px;
        }

        .tag.p2 {
            right: 0;
            background: rgba(59, 130, 246, 0.9);
            border-bottom-left-radius: 10px;
        }

        .portrait {
            min-height: 100%;
            position: relative;
        }

        .portrait-media {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 0;
            transform: scale(1.03);
        }

        .portrait-right .portrait-media {
            transform: scale(1.03) scaleX(-1);
        }

        .shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.95), rgba(0, 0, 0, 0.35) 45%, rgba(0, 0, 0, 0.1));
        }

        .info {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            padding: 14px;
        }

        .info.right {
            text-align: right;
        }

        .name {
            margin: 0;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            font-size: clamp(1.25rem, 2.8vw, 2.45rem);
            line-height: 0.95;
        }

        .alias {
            margin: 4px 0 12px;
            color: var(--soft);
            font-size: 1rem;
        }

        .stats {
            display: grid;
            gap: 7px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: 30px 1fr 40px;
            gap: 8px;
            align-items: center;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.74rem;
        }

        .bar {
            height: 8px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            background: rgba(255, 255, 255, 0.08);
            border-radius: 999px;
            overflow: hidden;
        }

        .bar > span {
            display: block;
            height: 100%;
            width: 0;
            transition: width 300ms ease;
            border-radius: 999px;
            box-shadow: 0 0 10px currentColor;
        }

        .center {
            display: grid;
            grid-template-rows: auto 1fr auto;
            gap: 10px;
            align-content: start;
            padding: 10px;
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 10px;
            color: var(--soft);
            font-family: 'Orbitron', sans-serif;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .legend span {
            padding: 4px 8px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.04);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            align-content: start;
            overflow-y: auto;
            padding-right: 4px;
        }

        .tile {
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            background: #0d1428;
            aspect-ratio: 1;
            overflow: hidden;
            cursor: pointer;
            transition: 140ms ease;
            position: relative;
            clip-path: polygon(10% 0, 100% 0, 90% 100%, 0 100%);
        }

        .tile:hover {
            transform: scale(1.06);
            z-index: 5;
            border-color: #fff;
        }

        .tile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.16);
            filter: grayscale(0.55) brightness(0.8);
            transition: 140ms ease;
        }

        .tile:hover img,
        .tile.focused img {
            filter: grayscale(0) brightness(1);
        }

        .tile.p1 {
            border-color: var(--p1);
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.9);
        }

        .tile.p2 {
            border-color: var(--p2);
            box-shadow: 0 0 12px rgba(59, 130, 246, 0.9);
        }

        .badge {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            font-family: 'Orbitron', sans-serif;
            font-size: 1.15rem;
            background: rgba(0, 0, 0, 0.55);
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.7);
        }

        .badge.p1 {
            color: #fff;
            background: rgba(239, 68, 68, 0.45);
        }

        .badge.p2 {
            color: #fff;
            background: rgba(59, 130, 246, 0.45);
        }

        .mobile-vs {
            display: none;
        }

        .instruction {
            border-top: 1px solid var(--line);
            padding-top: 8px;
            text-align: center;
            color: var(--soft);
            font-size: 0.9rem;
        }

        .vs-wrap {
            min-height: 100vh;
            position: relative;
            z-index: 2;
            display: flex;
            overflow: hidden;
        }

        .vs-side {
            width: 50%;
            position: relative;
            overflow: hidden;
            display: grid;
            place-items: center;
        }

        .vs-side.left {
            background: #5e0f23;
            transform: skewX(-10deg) translateX(-6%);
            border-right: 8px solid var(--gold);
        }

        .vs-side.right {
            background: #0f2f69;
            transform: skewX(-10deg) translateX(6%);
        }

        .vs-media {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 0;
            opacity: 0.72;
            transform: skewX(10deg) scale(1.18);
        }

        .vs-right-media {
            transform: skewX(10deg) scale(1.18) scaleX(-1);
        }

        .vs-layer {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.65), transparent 35%, transparent 65%, rgba(0, 0, 0, 0.65));
            z-index: 1;
        }

        .vs-title {
            position: relative;
            z-index: 2;
            text-align: center;
            transform: skewX(10deg);
        }

        .vs-title h3 {
            margin: 0;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            font-size: clamp(1.55rem, 4vw, 4.8rem);
            line-height: 0.9;
            text-shadow: 0 0 16px rgba(255, 255, 255, 0.7);
        }

        .vs-title p {
            margin: 8px 0 0;
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-size: 1rem;
            color: var(--gold);
        }

        .vs-core {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 6;
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(3.2rem, 12vw, 8rem);
            font-weight: 900;
            color: #fff;
            text-shadow: 4px 4px 0 var(--p1), -4px -4px 0 var(--gold), 0 0 44px rgba(255, 255, 255, 0.75);
            animation: pop 800ms ease infinite alternate;
        }

        @keyframes pop {
            from {
                transform: translate(-50%, -50%) scale(1);
            }

            to {
                transform: translate(-50%, -50%) scale(1.08);
            }
        }

        .reset-btn {
            position: absolute;
            left: 50%;
            bottom: 26px;
            transform: translateX(-50%);
            z-index: 10;
            border: 0;
            border-radius: 999px;
            padding: 12px 22px;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.86rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            background: #fff;
            color: #000;
            cursor: pointer;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
        }

        .reset-btn:hover {
            filter: brightness(0.88);
        }

        .fight-wrap {
            min-height: 100vh;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-rows: auto 1fr auto;
            gap: 10px;
            width: min(1300px, 96vw);
            margin: 0 auto;
            padding: 12px 0;
        }

        .fight-hud {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--hud);
            box-shadow: var(--shadow);
            padding: 10px 12px;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 10px;
        }

        .fight-side {
            display: grid;
            gap: 6px;
            color: var(--text);
            font-family: 'Orbitron', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .fight-side.right {
            text-align: right;
        }

        .fight-life {
            height: 14px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            overflow: hidden;
        }

        .fight-life > span {
            display: block;
            height: 100%;
            width: 100%;
            transition: width 160ms linear;
        }

        .fight-life .p1-life {
            background: linear-gradient(90deg, #ef4444, #fb7185);
        }

        .fight-life .p2-life {
            background: linear-gradient(90deg, #38bdf8, #2563eb);
        }

        .fight-timer {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(1.1rem, 2.2vw, 2.3rem);
            color: var(--gold);
            text-shadow: 0 0 12px rgba(250, 204, 21, 0.7);
            min-width: 88px;
            text-align: center;
        }

        .fight-arena {
            border: 1px solid var(--line);
            border-radius: 14px;
            overflow: hidden;
            background: linear-gradient(180deg, #091529, #112948 45%, #1c142d);
            box-shadow: var(--shadow);
            position: relative;
        }

        .fight-canvas {
            width: 100%;
            height: min(70vh, 560px);
            display: block;
        }

        .fight-result {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            background: rgba(0, 0, 0, 0.55);
            z-index: 4;
            opacity: 0;
            pointer-events: none;
            transition: opacity 180ms ease;
            text-align: center;
            padding: 16px;
        }

        .fight-result.show {
            opacity: 1;
            pointer-events: auto;
        }

        .fight-result h3 {
            margin: 0 0 10px;
            font-family: 'Orbitron', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: clamp(1.2rem, 3vw, 2.2rem);
        }

        .fight-controls {
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--hud);
            box-shadow: var(--shadow);
            padding: 10px 12px;
            color: var(--soft);
            display: flex;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 0.86rem;
        }

        .fight-controls strong {
            color: var(--text);
            font-family: 'Orbitron', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        @media (max-width: 1250px) {
            .arena {
                grid-template-columns: 1fr;
            }

            .panel {
                min-height: 420px;
            }

            .center {
                order: -1;
            }
        }

        @media (max-width: 760px) {
            .grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .legend {
                flex-wrap: wrap;
            }

            .mobile-vs {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-top: 1px solid var(--line);
                padding: 10px 4px 0;
                font-family: 'Orbitron', sans-serif;
                font-size: 0.8rem;
                text-transform: uppercase;
                color: var(--soft);
            }

            .vs-wrap {
                flex-direction: column;
            }

            .vs-side {
                width: 100%;
                min-height: 50vh;
                transform: none;
            }

            .vs-side.left {
                border-right: 0;
                border-bottom: 6px solid var(--gold);
            }

            .vs-media,
            .vs-right-media,
            .vs-title {
                transform: none;
            }

            .fight-hud {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .fight-side,
            .fight-side.right {
                text-align: center;
            }

            .fight-timer {
                order: -1;
            }
        }
    </style>
</head>
<body>
    <canvas id="fluidBg" class="fluid-canvas"></canvas>
    <div class="overlay-noise"></div>
    <button id="settingsToggle" class="settings-toggle" type="button" aria-label="Abrir configuracoes">⚙</button>
    <aside id="settingsPanel" class="settings-panel" aria-hidden="true">
        <h3 class="settings-title">Configuracoes</h3>

        <div class="settings-row">
            <label for="volumeControl">Volume</label>
            <input id="volumeControl" type="range" min="0" max="100" value="100">
        </div>

        <div class="settings-row">
            <label for="brightnessControl">Brilho</label>
            <input id="brightnessControl" type="range" min="60" max="140" value="100">
        </div>

        <div class="settings-row">
            <label for="themeControl">Tema</label>
            <select id="themeControl">
                <option value="default">Padrao</option>
                <option value="inferno">Inferno</option>
                <option value="cyber">Cyber</option>
            </select>
        </div>

        <p class="settings-tip">As preferencias ficam salvas neste navegador.</p>
    </aside>

    @php
        $publicPath = public_path();
        $gifDirectory = $publicPath . DIRECTORY_SEPARATOR . 'Gifs Personagens';
        $soundsDirectory = $publicPath . DIRECTORY_SEPARATOR . 'sons';
        $toPublicAsset = static function (string $absolutePath) use ($publicPath): string {
            $relative = str_replace($publicPath . DIRECTORY_SEPARATOR, '', $absolutePath);
            $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);
            return asset($relative);
        };

        $normalize = static function (string $value): string {
            return \Illuminate\Support\Str::of($value)
                ->lower()
                ->ascii()
                ->replaceMatches('/[^a-z0-9]+/', '')
                ->toString();
        };

        $humanize = static function (string $value): string {
            $clean = \Illuminate\Support\Str::of($value)
                ->replace(['_', '-'], ' ')
                ->replaceMatches('/\b(gif|gifs)\b/i', '')
                ->squish()
                ->toString();

            return \Illuminate\Support\Str::of($clean)->title()->toString();
        };

        $iconFiles = glob(
            $publicPath . DIRECTORY_SEPARATOR . '*.{jpg,jpeg,png,webp,jfif,JPG,JPEG,PNG,WEBP,JFIF}',
            GLOB_BRACE
        ) ?: [];

        $icons = [];
        foreach ($iconFiles as $iconPath) {
            $baseName = pathinfo($iconPath, PATHINFO_FILENAME);
            $iconKey = $normalize($baseName);

            if ($iconKey === '') {
                continue;
            }

            $icons[] = [
                'name' => $baseName,
                'normalized' => $iconKey,
                'asset' => asset(basename($iconPath)),
            ];
        }

        $manualGifToIconMap = [
            'homemaranha' => 'spiderman',
            'chuckygifs' => 'chucky',
            'lieber' => 'lieberdemo',
            'sukunamegumi' => 'sukunacorpomegumi',
            'sukuna' => 'sukunaeraheian',
            'princesinhasofiagif' => 'princesinhasofia',
            'sakuracardicaptor' => 'sakuracardcaptor',
            'tungtungtungtungsahur' => 'tungtungsarur',
            'tungtungtungtungsahurgif' => 'tungtungsarur',
            'annabelle' => 'anabelle',
            'valak' => 'valak',
        ];

        $manualSoundToIconMap = [
            'homemaranha' => 'spiderman',
            'satorugojoemportugues' => 'gojolouco',
            'sukunajujutsukaisen' => 'sukunaeraheian',
            'gutterman' => 'gutterman',
            'tungtungsahur' => 'tungtungsarur',
            'tungtungsarur' => 'tungtungsarur',
            'annabelle' => 'anabelle',
            'anabelle' => 'anabelle',
            'valak' => 'valak',
        ];

        $palette = ['#ef4444', '#3b82f6', '#f59e0b', '#22c55e', '#a855f7', '#f97316', '#06b6d4', '#e11d48'];

        $audioAssets = [
            'music' => null,
            'hover' => null,
            'voices' => [],
        ];

        $soundFiles = is_dir($soundsDirectory)
            ? (glob($soundsDirectory . DIRECTORY_SEPARATOR . '*.{mp3,wav,ogg,m4a,MP3,WAV,OGG,M4A}', GLOB_BRACE) ?: [])
            : [];

        foreach ($soundFiles as $soundPath) {
            $baseName = pathinfo($soundPath, PATHINFO_FILENAME);
            $normalizedName = $normalize($baseName);

            if ($audioAssets['music'] === null && preg_match('/musica|music|trilha|battle|luta/i', $baseName)) {
                $audioAssets['music'] = $toPublicAsset($soundPath);
                continue;
            }

            if ($audioAssets['hover'] === null && preg_match('/toque|hover|passar/i', $baseName)) {
                $audioAssets['hover'] = $toPublicAsset($soundPath);
                continue;
            }

            $voiceKey = $normalizedName;
            if (preg_match('/\[(.*?)\]/', $baseName, $matches)) {
                $voiceKey = $normalize($matches[1]);
            }

            $resolvedVoiceKey = $manualSoundToIconMap[$voiceKey] ?? $voiceKey;

            if (!isset($audioAssets['voices'][$resolvedVoiceKey])) {
                $audioAssets['voices'][$resolvedVoiceKey] = $toPublicAsset($soundPath);
            }
        }

        if ($audioAssets['music'] === null && !empty($soundFiles)) {
            $audioAssets['music'] = $toPublicAsset($soundFiles[0]);
        }

        $gifFiles = is_dir($gifDirectory)
            ? (glob($gifDirectory . DIRECTORY_SEPARATOR . '*.{gif,GIF}', GLOB_BRACE) ?: [])
            : [];

        $gifByKey = [];
        foreach ($gifFiles as $gifPath) {
            $gifBase = pathinfo($gifPath, PATHINFO_FILENAME);
            $gifKey = $normalize($gifBase);
            $variants = array_filter([
                $gifKey,
                preg_replace('/gifs?$/', '', $gifKey),
                preg_replace('/\d+$/', '', $gifKey),
                preg_replace('/gifs?\d*$/', '', $gifKey),
            ]);

            foreach ($variants as $variant) {
                $resolved = $manualGifToIconMap[$variant] ?? $variant;
                if (!isset($gifByKey[$resolved])) {
                    $gifByKey[$resolved] = $gifPath;
                }
            }
        }

        $characters = [];

        foreach ($icons as $icon) {
            $iconKey = $icon['normalized'];
            $gifPath = null;

            if (isset($gifByKey[$iconKey])) {
                $gifPath = $gifByKey[$iconKey];
            } else {
                foreach ($gifByKey as $gifKey => $candidatePath) {
                    if (str_contains($gifKey, $iconKey) || str_contains($iconKey, $gifKey)) {
                        $gifPath = $candidatePath;
                        break;
                    }
                }
            }

            $name = $humanize($icon['name']);
            $id = \Illuminate\Support\Str::slug($name, '-');
            $seed = abs(crc32($id));

            $characters[] = [
                'id' => $id,
                'name' => $name,
                'alias' => 'Desafiante',
                'baseColor' => $palette[$seed % count($palette)],
                'thumbnail' => $icon['asset'],
                'portrait' => $gifPath ? $toPublicAsset($gifPath) : $icon['asset'],
                'voice' => (function () use ($audioAssets, $iconKey) {
                    if (isset($audioAssets['voices'][$iconKey])) {
                        return $audioAssets['voices'][$iconKey];
                    }

                    foreach ($audioAssets['voices'] as $voiceKey => $voicePath) {
                        if (str_contains($voiceKey, $iconKey) || str_contains($iconKey, $voiceKey)) {
                            return $voicePath;
                        }
                    }

                    return null;
                })(),
                'stats' => [
                    'force' => 60 + ($seed % 41),
                    'speed' => 60 + (int) (($seed / 7) % 41),
                    'intelligence' => 60 + (int) (($seed / 13) % 41),
                    'combat' => 60 + (int) (($seed / 17) % 41),
                ],
            ];
        }

        usort($characters, static fn ($a, $b) => strcmp($a['name'], $b['name']));
    @endphp

    <section id="screen-start" class="screen active">
        <div class="start-wrap" id="startButton">
            <div>
                <h1 class="start-title">Multiverso</h1>
                <p class="start-sub">Battle</p>
                <span class="press-start">Click to start</span>
                <p class="start-foot">Devs: Jhonatan, Cleidimar, Isaque, Gabriel, Larissa e Marley</p>
            </div>
        </div>
    </section>

    <section id="screen-select" class="screen">
        <div class="select-wrap">
            <header class="header">
                <h2 id="selectingTitle"><span class="p1">Player 1: Select your hero</span></h2>
            </header>

            <main class="arena">
                <aside class="panel" id="panelP1">
                    <div class="tag p1">1P</div>
                    <div class="portrait" id="leftPortrait"></div>
                </aside>

                <section class="panel center">
                    <div class="legend">
                        <span>Hover: Preview</span>
                        <span>Click: Select</span>
                        <span>Auto VS</span>
                    </div>

                    <div class="grid" id="charactersGrid"></div>

                    <div class="instruction">
                        Sons carregados de public/sons: trilha, hover e falas por personagem (quando o nome bater).
                    </div>

                    <div class="mobile-vs">
                        <div id="mobileP1">P1: ...</div>
                        <div>VS</div>
                        <div id="mobileP2">P2: ...</div>
                    </div>
                </section>

                <aside class="panel" id="panelP2">
                    <div class="tag p2">2P</div>
                    <div class="portrait portrait-right" id="rightPortrait"></div>
                </aside>
            </main>
        </div>
    </section>

    <section id="screen-vs" class="screen">
        <div class="vs-wrap">
            <div class="vs-side left" id="vsLeft"></div>
            <div class="vs-side right" id="vsRight"></div>
            <div class="vs-core">VS</div>
            <button class="reset-btn" id="fightBtn" type="button" style="bottom: 84px;">Lutar Agora</button>
            <button class="reset-btn" id="resetBtn" type="button">Nova Batalha</button>
        </div>
    </section>

    <section id="screen-fight" class="screen">
        <div class="fight-wrap">
            <header class="fight-hud">
                <div class="fight-side">
                    <div id="fightP1Name">Player 1</div>
                    <div class="fight-life"><span id="fightP1Life" class="p1-life"></span></div>
                </div>

                <div id="fightTimer" class="fight-timer">60</div>

                <div class="fight-side right">
                    <div id="fightP2Name">Player 2</div>
                    <div class="fight-life"><span id="fightP2Life" class="p2-life"></span></div>
                </div>
            </header>

            <main class="fight-arena">
                <canvas id="fightCanvas" class="fight-canvas"></canvas>
                <div id="fightResult" class="fight-result">
                    <div>
                        <h3 id="fightResultText">Vitoria</h3>
                        <button class="reset-btn" id="fightRematchBtn" type="button" style="position: static; transform: none;">Jogar Novamente</button>
                    </div>
                </div>
            </main>

            <footer class="fight-controls">
                <div><strong>P1:</strong> A/D mover, W pular, F soco, G chute</div>
                <div><strong>P2:</strong> Setas mover/pular, L soco, K chute</div>
            </footer>
        </div>
    </section>

    <script>
        const charactersList = @json($characters);
        const audioAssets = @json($audioAssets);
        const screens = {
            start: document.getElementById('screen-start'),
            select: document.getElementById('screen-select'),
            vs: document.getElementById('screen-vs'),
            fight: document.getElementById('screen-fight'),
        };

        const selectingTitle = document.getElementById('selectingTitle');
        const panelP1 = document.getElementById('panelP1');
        const panelP2 = document.getElementById('panelP2');
        const leftPortrait = document.getElementById('leftPortrait');
        const rightPortrait = document.getElementById('rightPortrait');
        const charactersGrid = document.getElementById('charactersGrid');
        const mobileP1 = document.getElementById('mobileP1');
        const mobileP2 = document.getElementById('mobileP2');
        const vsLeft = document.getElementById('vsLeft');
        const vsRight = document.getElementById('vsRight');
        const settingsToggle = document.getElementById('settingsToggle');
        const settingsPanel = document.getElementById('settingsPanel');
        const volumeControl = document.getElementById('volumeControl');
        const brightnessControl = document.getElementById('brightnessControl');
        const themeControl = document.getElementById('themeControl');
        const fightBtn = document.getElementById('fightBtn');
        const fightCanvas = document.getElementById('fightCanvas');
        const fightCtx = fightCanvas.getContext('2d');
        const fightP1Name = document.getElementById('fightP1Name');
        const fightP2Name = document.getElementById('fightP2Name');
        const fightP1Life = document.getElementById('fightP1Life');
        const fightP2Life = document.getElementById('fightP2Life');
        const fightTimer = document.getElementById('fightTimer');
        const fightResult = document.getElementById('fightResult');
        const fightResultText = document.getElementById('fightResultText');
        const fightRematchBtn = document.getElementById('fightRematchBtn');

        const SETTINGS_KEY = 'multiverso-settings-v1';
        const settingsState = {
            volume: 100,
            brightness: 100,
            theme: 'default',
        };

        const soundState = {
            bgMusic: null,
            hoverSfx: null,
            activeVoice: null,
            hoverCooldownUntil: 0,
        };

        const audioMix = {
            music: 0.35,
            hover: 0.6,
            voiceBoost: 2.4,
        };

        let voiceAudioContext = null;
        let voiceGainNode = null;

        const state = {
            gameState: 'start',
            p1: null,
            p2: null,
            hoveredChar: charactersList[0] || null,
            selectingFor: 'P1',
        };

        const fightState = {
            running: false,
            raf: null,
            lastTs: 0,
            timer: 60,
            p1: null,
            p2: null,
            keys: Object.create(null),
            gravity: 2100,
            groundY: 0,
            worldWidth: 0,
            worldHeight: 0,
        };

        const keyMap = {
            p1: { left: 'KeyA', right: 'KeyD', jump: 'KeyW', punch: 'KeyF', kick: 'KeyG' },
            p2: { left: 'ArrowLeft', right: 'ArrowRight', jump: 'ArrowUp', punch: 'KeyL', kick: 'KeyK' },
        };

        function buildAudio(url, loop = false, channel = 'default') {
            if (!url) {
                return null;
            }

            const audio = new Audio(url);
            audio.loop = loop;
            audio.preload = 'auto';

            const baseVolume = settingsState.volume / 100;
            if (channel === 'music') {
                audio.volume = Math.min(1, baseVolume * audioMix.music);
            } else if (channel === 'hover') {
                audio.volume = Math.min(1, baseVolume * audioMix.hover);
            } else {
                audio.volume = baseVolume;
            }

            return audio;
        }

        function ensureVoiceGain() {
            if (!window.AudioContext && !window.webkitAudioContext) {
                return null;
            }

            if (!voiceAudioContext) {
                const Ctx = window.AudioContext || window.webkitAudioContext;
                voiceAudioContext = new Ctx();
            }

            if (!voiceGainNode) {
                voiceGainNode = voiceAudioContext.createGain();
                voiceGainNode.connect(voiceAudioContext.destination);
            }

            return voiceGainNode;
        }

        function initSoundAssets() {
            if (!soundState.bgMusic && audioAssets.music) {
                soundState.bgMusic = buildAudio(audioAssets.music, true, 'music');
            }

            if (!soundState.hoverSfx && audioAssets.hover) {
                soundState.hoverSfx = buildAudio(audioAssets.hover, false, 'hover');
            }
        }

        function startBackgroundMusic() {
            initSoundAssets();

            if (!soundState.bgMusic) {
                return;
            }

            soundState.bgMusic.currentTime = 0;
            soundState.bgMusic.play().catch(() => {});
        }

        function playHoverSound() {
            initSoundAssets();

            if (!soundState.hoverSfx) {
                return;
            }

            const now = Date.now();
            if (now < soundState.hoverCooldownUntil) {
                return;
            }

            soundState.hoverCooldownUntil = now + 160;
            soundState.hoverSfx.currentTime = 0;
            soundState.hoverSfx.play().catch(() => {});
        }

        function playCharacterVoice(character) {
            if (!character.voice) {
                return;
            }

            if (soundState.activeVoice) {
                soundState.activeVoice.pause();
                soundState.activeVoice.currentTime = 0;
            }

            const voice = buildAudio(character.voice, false, 'voice');
            if (!voice) {
                return;
            }

            const gainNode = ensureVoiceGain();
            if (gainNode && voiceAudioContext) {
                try {
                    if (voiceAudioContext.state === 'suspended') {
                        voiceAudioContext.resume().catch(() => {});
                    }

                    const source = voiceAudioContext.createMediaElementSource(voice);
                    source.connect(gainNode);
                } catch {
                    // Fallback para navegadores/estados que nao permitirem o node.
                }
            }

            soundState.activeVoice = voice;
            voice.play().catch(() => {});
        }

        function syncAudioVolume() {
            const volume = settingsState.volume / 100;

            if (soundState.bgMusic) {
                soundState.bgMusic.volume = Math.min(1, volume * audioMix.music);
            }

            if (soundState.hoverSfx) {
                soundState.hoverSfx.volume = Math.min(1, volume * audioMix.hover);
            }

            if (soundState.activeVoice) {
                soundState.activeVoice.volume = volume;
            }

            if (voiceGainNode) {
                voiceGainNode.gain.value = Math.max(1, volume * audioMix.voiceBoost);
            }
        }

        function applyVolume(value) {
            const volume = Math.max(0, Math.min(100, value));
            document.querySelectorAll('audio, video').forEach((media) => {
                media.volume = volume / 100;
            });
            syncAudioVolume();
        }

        function applyBrightness(value) {
            const brightness = Math.max(60, Math.min(140, value));
            document.documentElement.style.setProperty('--brightness-level', `${brightness / 100}`);
        }

        function applyTheme(theme) {
            const validTheme = ['default', 'inferno', 'cyber'].includes(theme) ? theme : 'default';

            if (validTheme === 'default') {
                document.body.removeAttribute('data-theme');
            } else {
                document.body.setAttribute('data-theme', validTheme);
            }
        }

        function syncSettingsUI() {
            volumeControl.value = String(settingsState.volume);
            brightnessControl.value = String(settingsState.brightness);
            themeControl.value = settingsState.theme;
        }

        function persistSettings() {
            localStorage.setItem(SETTINGS_KEY, JSON.stringify(settingsState));
        }

        function applyAllSettings() {
            applyVolume(settingsState.volume);
            applyBrightness(settingsState.brightness);
            applyTheme(settingsState.theme);
            syncSettingsUI();
        }

        function loadSettings() {
            try {
                const raw = localStorage.getItem(SETTINGS_KEY);
                if (!raw) {
                    applyAllSettings();
                    return;
                }

                const parsed = JSON.parse(raw);
                settingsState.volume = 100;
                settingsState.brightness = Number(parsed.brightness ?? settingsState.brightness);
                settingsState.theme = String(parsed.theme ?? settingsState.theme);
                applyAllSettings();
            } catch {
                applyAllSettings();
            }
        }

        function toggleSettingsPanel(force = null) {
            const shouldOpen = typeof force === 'boolean' ? force : !settingsPanel.classList.contains('open');
            settingsPanel.classList.toggle('open', shouldOpen);
            settingsPanel.setAttribute('aria-hidden', shouldOpen ? 'false' : 'true');
        }

        function showScreen(screenKey) {
            Object.values(screens).forEach((screen) => screen.classList.remove('active'));
            screens[screenKey].classList.add('active');
            state.gameState = screenKey;
        }

        function mediaMarkup(character, right = false) {
            if (character.videoEmbed) {
                return `<iframe src="${character.videoEmbed}" class="portrait-media" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" style="border: none;"></iframe>`;
            }

            const rightClass = right ? ' style="transform: scale(1.03) scaleX(-1);"' : '';
            return `<img src="${character.portrait}" alt="${character.name}" class="portrait-media"${rightClass}>`;
        }

        function statsMarkup(character) {
            const stats = [
                ['FOR', character.stats.force],
                ['VEL', character.stats.speed],
                ['INT', character.stats.intelligence],
                ['COM', character.stats.combat],
            ];

            return stats.map(([label, value]) => `
                <div class="stats-row">
                    <span>${label}</span>
                    <div class="bar"><span style="width:${value}%; color:${character.baseColor}; background:${character.baseColor};"></span></div>
                    <span>${value}</span>
                </div>
            `).join('');
        }

        function panelMarkup(character, side) {
            const right = side === 'right';
            const rightClass = right ? 'right' : '';
            return `
                ${mediaMarkup(character, right)}
                <div class="shade"></div>
                <div class="info ${rightClass}">
                    <h3 class="name">${character.name}</h3>
                    <p class="alias">${character.alias}</p>
                    <div class="stats">${statsMarkup(character)}</div>
                </div>
            `;
        }

        function updatePanels() {
            if (!charactersList.length) {
                return;
            }

            const defaultRight = charactersList[Math.min(1, charactersList.length - 1)] || charactersList[0];
            const leftDisplay = state.p1 || (state.selectingFor === 'P1' ? state.hoveredChar : charactersList[0]);
            const rightDisplay = state.p2 || (state.selectingFor === 'P2' ? state.hoveredChar : defaultRight);

            leftPortrait.innerHTML = panelMarkup(leftDisplay, 'left');
            rightPortrait.innerHTML = panelMarkup(rightDisplay, 'right');

            mobileP1.textContent = `P1: ${state.p1 ? state.p1.name : '...'}`;
            mobileP2.textContent = `P2: ${state.p2 ? state.p2.name : '...'}`;

            panelP1.classList.toggle('active-p1', state.selectingFor === 'P1');
            panelP2.classList.toggle('active-p2', state.selectingFor === 'P2');
        }

        function updateTitle() {
            if (state.selectingFor === 'P1') {
                selectingTitle.innerHTML = '<span class="p1">Player 1: Select your hero</span>';
                return;
            }

            if (state.selectingFor === 'P2') {
                selectingTitle.innerHTML = '<span class="p2">Player 2: Choose opponent</span>';
                return;
            }

            selectingTitle.innerHTML = '<span class="done">Prepare for battle</span>';
        }

        function renderGrid() {
            charactersGrid.innerHTML = '';

            if (!charactersList.length) {
                charactersGrid.innerHTML = '<p style="grid-column: 1 / -1; text-align: center; color: #fca5a5;">Nenhum personagem encontrado em public/Gifs Personagens.</p>';
                return;
            }

            charactersList.forEach((char) => {
                const tile = document.createElement('button');
                tile.type = 'button';
                tile.className = 'tile';
                tile.dataset.id = char.id;

                tile.innerHTML = `<img src="${char.thumbnail}" alt="${char.name}">`;

                tile.addEventListener('mouseenter', () => {
                    state.hoveredChar = char;
                    updatePanels();
                    document.querySelectorAll('.tile').forEach((item) => item.classList.remove('focused'));
                    tile.classList.add('focused');
                    playHoverSound();
                });

                tile.addEventListener('click', () => {
                    if (state.selectingFor === 'DONE') {
                        return;
                    }

                    if (state.p1 && state.p1.id === char.id) {
                        return;
                    }

                    if (state.p2 && state.p2.id === char.id) {
                        return;
                    }

                    playCharacterVoice(char);

                    if (state.selectingFor === 'P1') {
                        state.p1 = char;
                        state.selectingFor = 'P2';
                        state.hoveredChar = charactersList[charactersList.length - 1];
                    } else {
                        state.p2 = char;
                        state.selectingFor = 'DONE';
                        setTimeout(() => {
                            buildVs();
                            showScreen('vs');
                        }, 700);
                    }

                    updateTitle();
                    updatePanels();
                    applySelections();
                });

                charactersGrid.appendChild(tile);
            });

            applySelections();
        }

        function applySelections() {
            document.querySelectorAll('.tile').forEach((tile) => {
                const id = tile.dataset.id;
                tile.classList.remove('p1', 'p2');

                tile.querySelectorAll('.badge').forEach((badge) => badge.remove());

                if (state.p1 && state.p1.id === id) {
                    tile.classList.add('p1');
                    const badge = document.createElement('div');
                    badge.className = 'badge p1';
                    badge.textContent = '1P';
                    tile.appendChild(badge);
                }

                if (state.p2 && state.p2.id === id) {
                    tile.classList.add('p2');
                    const badge = document.createElement('div');
                    badge.className = 'badge p2';
                    badge.textContent = '2P';
                    tile.appendChild(badge);
                }
            });
        }

        function vsPanelMarkup(character, playerLabel, right = false) {
            const media = character.videoEmbed
                ? `<iframe src="${character.videoEmbed}" class="vs-media ${right ? 'vs-right-media' : ''}" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" style="border: none;"></iframe>`
                : `<img src="${character.portrait}" alt="${character.name}" class="vs-media ${right ? 'vs-right-media' : ''}">`;

            return `
                ${media}
                <div class="vs-layer"></div>
                <div class="vs-title">
                    <h3>${character.name}</h3>
                    <p>${playerLabel}</p>
                </div>
            `;
        }

        function buildVs() {
            if (!state.p1 || !state.p2) {
                return;
            }

            vsLeft.innerHTML = vsPanelMarkup(state.p1, 'Player 1', false);
            vsRight.innerHTML = vsPanelMarkup(state.p2, 'Player 2', true);
        }

        function resizeFightCanvas() {
            const rect = fightCanvas.getBoundingClientRect();
            const ratio = window.devicePixelRatio || 1;
            const w = Math.max(300, Math.floor(rect.width));
            const h = Math.max(260, Math.floor(rect.height));
            fightCanvas.width = Math.floor(w * ratio);
            fightCanvas.height = Math.floor(h * ratio);
            fightCtx.setTransform(ratio, 0, 0, ratio, 0, 0);
            fightState.worldWidth = w;
            fightState.worldHeight = h;
            fightState.groundY = h - 72;
        }

        function makeFighter(character, x, facing) {
            const sprite = new Image();
            sprite.src = character.thumbnail;

            return {
                character,
                sprite,
                x,
                y: 0,
                w: 76,
                h: 136,
                vx: 0,
                vy: 0,
                facing,
                speed: 340,
                jumpPower: 880,
                life: 100,
                attackCd: 0,
                attackTime: 0,
                attackType: null,
                hasHitCurrentAttack: false,
                hitStun: 0,
                color: character.baseColor,
                animPhase: Math.random() * Math.PI * 2,
            };
        }

        function startFight() {
            if (!state.p1 || !state.p2) {
                return;
            }

            showScreen('fight');
            resizeFightCanvas();

            fightState.timer = 60;
            fightState.lastTs = 0;
            fightState.running = true;

            fightState.p1 = makeFighter(state.p1, fightState.worldWidth * 0.25, 1);
            fightState.p2 = makeFighter(state.p2, fightState.worldWidth * 0.75, -1);
            fightState.p1.y = fightState.groundY - fightState.p1.h;
            fightState.p2.y = fightState.groundY - fightState.p2.h;

            fightP1Name.textContent = state.p1.name;
            fightP2Name.textContent = state.p2.name;
            fightResult.classList.remove('show');
            updateFightHud();

            if (fightState.raf) {
                cancelAnimationFrame(fightState.raf);
                fightState.raf = null;
            }

            fightState.raf = requestAnimationFrame(fightLoop);
        }

        function stopFight() {
            fightState.running = false;
            if (fightState.raf) {
                cancelAnimationFrame(fightState.raf);
                fightState.raf = null;
            }
        }

        function updateFightHud() {
            const p1Life = Math.max(0, Math.min(100, fightState.p1?.life ?? 0));
            const p2Life = Math.max(0, Math.min(100, fightState.p2?.life ?? 0));
            fightP1Life.style.width = `${p1Life}%`;
            fightP2Life.style.width = `${p2Life}%`;
            fightTimer.textContent = `${Math.max(0, Math.ceil(fightState.timer))}`;
        }

        function resolveAttack(attacker, defender) {
            if (attacker.attackTime <= 0 || attacker.hasHitCurrentAttack || !attacker.attackType) {
                return;
            }

            const isKick = attacker.attackType === 'kick';
            const reach = isKick ? 116 : 88;
            const verticalTolerance = isKick ? 98 : 82;
            const centerA = attacker.x + attacker.w / 2;
            const centerD = defender.x + defender.w / 2;
            const dx = centerD - centerA;
            const dy = Math.abs((attacker.y + attacker.h / 2) - (defender.y + defender.h / 2));
            const inFront = attacker.facing === 1 ? dx > 0 : dx < 0;

            if (inFront && Math.abs(dx) <= reach && dy < verticalTolerance) {
                const damage = isKick
                    ? 14 + Math.floor(Math.random() * 7)
                    : 8 + Math.floor(Math.random() * 6);
                defender.life = Math.max(0, defender.life - damage);
                defender.hitStun = isKick ? 0.22 : 0.14;
                defender.vx += attacker.facing * (isKick ? 310 : 220);
                defender.vy -= isKick ? 120 : 40;
                attacker.hasHitCurrentAttack = true;
            }
        }

        function updateFighter(fighter, controls, dt) {
            const left = !!fightState.keys[controls.left];
            const right = !!fightState.keys[controls.right];
            const jump = !!fightState.keys[controls.jump];
            const punch = !!fightState.keys[controls.punch];
            const kick = !!fightState.keys[controls.kick];
            const onGround = fighter.y >= fightState.groundY - fighter.h - 0.1;
            const speedFactor = Math.min(1, Math.abs(fighter.vx) / fighter.speed);

            fighter.attackCd = Math.max(0, fighter.attackCd - dt);
            fighter.attackTime = Math.max(0, fighter.attackTime - dt);
            fighter.hitStun = Math.max(0, fighter.hitStun - dt);
            fighter.animPhase += dt * (onGround ? (5 + speedFactor * 9) : 4);

            if (fighter.attackTime <= 0) {
                fighter.hasHitCurrentAttack = false;
                fighter.attackType = null;
            }

            if (fighter.hitStun <= 0) {
                if (left === right) {
                    fighter.vx *= 0.82;
                } else if (left) {
                    fighter.vx = -fighter.speed;
                    fighter.facing = -1;
                } else if (right) {
                    fighter.vx = fighter.speed;
                    fighter.facing = 1;
                }

                if (jump && onGround) {
                    fighter.vy = -fighter.jumpPower;
                }

                if ((punch || kick) && fighter.attackCd <= 0) {
                    fighter.attackType = kick ? 'kick' : 'punch';
                    fighter.attackCd = kick ? 0.58 : 0.4;
                    fighter.attackTime = kick ? 0.24 : 0.18;
                    fighter.hasHitCurrentAttack = false;
                }
            }

            fighter.vy += fightState.gravity * dt;
            fighter.x += fighter.vx * dt;
            fighter.y += fighter.vy * dt;

            const minX = 20;
            const maxX = fightState.worldWidth - fighter.w - 20;
            fighter.x = Math.max(minX, Math.min(maxX, fighter.x));

            if (fighter.y > fightState.groundY - fighter.h) {
                fighter.y = fightState.groundY - fighter.h;
                fighter.vy = 0;
            }
        }

        function drawFighter(fighter) {
            fightCtx.save();
            const cx = fighter.x + fighter.w / 2;
            const cy = fighter.y + fighter.h / 2;
            const walk = Math.sin(fighter.animPhase);
            const isPunching = fighter.attackType === 'punch' && fighter.attackTime > 0;
            const isKicking = fighter.attackType === 'kick' && fighter.attackTime > 0;
            const attackProgress = isPunching
                ? Math.min(1, fighter.attackTime / 0.18)
                : (isKicking ? Math.min(1, fighter.attackTime / 0.24) : 0);
            const frontArmReach = isPunching ? (26 + (1 - attackProgress) * 24) : 16;
            const frontLegReach = isKicking ? (24 + (1 - attackProgress) * 34) : 8;
            const bodyLean = isPunching || isKicking ? 5 : 0;

            fightCtx.translate(cx, cy);
            fightCtx.scale(fighter.facing, 1);

            fightCtx.fillStyle = 'rgba(0,0,0,0.3)';
            fightCtx.beginPath();
            fightCtx.ellipse(0, fighter.h / 2 + 10, 38, 11, 0, 0, Math.PI * 2);
            fightCtx.fill();

            fightCtx.lineCap = 'round';
            fightCtx.lineJoin = 'round';

            const neckY = -34;
            const hipY = 20;
            const shoulderY = -8;
            const headR = 18;
            const backStep = -9 + walk * 5;
            const frontStep = 11 - walk * 5;

            // Torso
            fightCtx.strokeStyle = 'rgba(235,245,255,0.88)';
            fightCtx.lineWidth = 8;
            fightCtx.beginPath();
            fightCtx.moveTo(-bodyLean * 0.5, neckY);
            fightCtx.lineTo(bodyLean, hipY);
            fightCtx.stroke();

            // Back arm
            fightCtx.strokeStyle = 'rgba(180,210,240,0.9)';
            fightCtx.lineWidth = 6;
            fightCtx.beginPath();
            fightCtx.moveTo(-8, shoulderY);
            fightCtx.lineTo(-24, 12 + walk * 3);
            fightCtx.stroke();

            // Front arm (punch)
            fightCtx.strokeStyle = '#facc15';
            fightCtx.lineWidth = 7;
            fightCtx.beginPath();
            fightCtx.moveTo(8, shoulderY - 1);
            fightCtx.lineTo(frontArmReach, isPunching ? -2 : 10 + walk * 2);
            fightCtx.stroke();

            // Back leg
            fightCtx.strokeStyle = 'rgba(170,200,235,0.95)';
            fightCtx.lineWidth = 8;
            fightCtx.beginPath();
            fightCtx.moveTo(-6, hipY);
            fightCtx.lineTo(-16, 48 + backStep);
            fightCtx.stroke();

            // Front leg (kick)
            fightCtx.strokeStyle = '#7dd3fc';
            fightCtx.lineWidth = 8;
            fightCtx.beginPath();
            fightCtx.moveTo(8, hipY);
            fightCtx.lineTo(frontLegReach, 48 + frontStep - (isKicking ? 22 : 0));
            fightCtx.stroke();

            // Head with character texture
            fightCtx.save();
            fightCtx.beginPath();
            fightCtx.arc(0, -54, headR, 0, Math.PI * 2);
            fightCtx.closePath();
            fightCtx.clip();

            if (fighter.sprite.complete && fighter.sprite.naturalWidth > 0) {
                fightCtx.drawImage(fighter.sprite, -headR, -72, headR * 2, headR * 2);
            } else {
                fightCtx.fillStyle = fighter.color;
                fightCtx.fillRect(-headR, -72, headR * 2, headR * 2);
            }

            fightCtx.restore();

            // Head outline
            fightCtx.strokeStyle = 'rgba(255,255,255,0.9)';
            fightCtx.lineWidth = 3;
            fightCtx.beginPath();
            fightCtx.arc(0, -54, headR, 0, Math.PI * 2);
            fightCtx.stroke();

            // Hit flash helper
            if (fighter.hitStun > 0) {
                fightCtx.strokeStyle = 'rgba(255,255,255,0.9)';
                fightCtx.lineWidth = 2;
                fightCtx.strokeRect(-30, -74, 60, 132);
            }

            if (isPunching || isKicking) {
                fightCtx.fillStyle = 'rgba(250,204,21,0.2)';
                fightCtx.beginPath();
                fightCtx.arc(22, -4, 14, 0, Math.PI * 2);
                fightCtx.fill();
            }

            fightCtx.restore();
        }

        function drawFightArena() {
            const w = fightState.worldWidth;
            const h = fightState.worldHeight;

            fightCtx.clearRect(0, 0, w, h);

            const sky = fightCtx.createLinearGradient(0, 0, 0, h);
            sky.addColorStop(0, '#0b1a33');
            sky.addColorStop(0.55, '#10294d');
            sky.addColorStop(1, '#1e1730');
            fightCtx.fillStyle = sky;
            fightCtx.fillRect(0, 0, w, h);

            fightCtx.fillStyle = 'rgba(255,255,255,0.06)';
            for (let i = 0; i < 12; i += 1) {
                const x = (i * w) / 12;
                fightCtx.fillRect(x, 0, 1, h);
            }

            fightCtx.fillStyle = 'rgba(0,0,0,0.35)';
            fightCtx.fillRect(0, fightState.groundY, w, h - fightState.groundY);

            fightCtx.strokeStyle = 'rgba(250,204,21,0.55)';
            fightCtx.lineWidth = 2;
            fightCtx.beginPath();
            fightCtx.moveTo(0, fightState.groundY);
            fightCtx.lineTo(w, fightState.groundY);
            fightCtx.stroke();
        }

        function finishFightByLife() {
            const p1 = fightState.p1.life;
            const p2 = fightState.p2.life;

            if (p1 === p2) {
                return 'Empate';
            }

            return p1 > p2 ? `${state.p1.name} venceu!` : `${state.p2.name} venceu!`;
        }

        function endFight(message) {
            stopFight();
            fightResultText.textContent = message;
            fightResult.classList.add('show');
        }

        function fightLoop(ts) {
            if (!fightState.running) {
                return;
            }

            if (!fightState.lastTs) {
                fightState.lastTs = ts;
            }

            const dt = Math.min(0.033, (ts - fightState.lastTs) / 1000);
            fightState.lastTs = ts;

            fightState.timer = Math.max(0, fightState.timer - dt);

            updateFighter(fightState.p1, keyMap.p1, dt);
            updateFighter(fightState.p2, keyMap.p2, dt);

            if (fightState.p2.x > fightState.p1.x) {
                fightState.p1.facing = 1;
                fightState.p2.facing = -1;
            } else {
                fightState.p1.facing = -1;
                fightState.p2.facing = 1;
            }

            resolveAttack(fightState.p1, fightState.p2);
            resolveAttack(fightState.p2, fightState.p1);

            drawFightArena();
            drawFighter(fightState.p1);
            drawFighter(fightState.p2);
            updateFightHud();

            if (fightState.p1.life <= 0 || fightState.p2.life <= 0) {
                endFight(finishFightByLife());
                return;
            }

            if (fightState.timer <= 0) {
                endFight(finishFightByLife());
                return;
            }

            fightState.raf = requestAnimationFrame(fightLoop);
        }

        function resetGame() {
            stopFight();
            state.p1 = null;
            state.p2 = null;
            state.selectingFor = 'P1';
            state.hoveredChar = charactersList[0] || null;
            updateTitle();
            renderGrid();
            updatePanels();
            showScreen('start');
        }

        document.getElementById('startButton').addEventListener('click', () => {
            startBackgroundMusic();
            showScreen('select');
            updateTitle();
            renderGrid();
            updatePanels();
        });

        document.getElementById('resetBtn').addEventListener('click', () => {
            resetGame();
        });

        fightBtn.addEventListener('click', () => {
            startFight();
        });

        fightRematchBtn.addEventListener('click', () => {
            startFight();
        });

        document.addEventListener('keydown', (event) => {
            fightState.keys[event.code] = true;
        });

        document.addEventListener('keyup', (event) => {
            fightState.keys[event.code] = false;
        });

        settingsToggle.addEventListener('click', () => {
            toggleSettingsPanel();
        });

        document.addEventListener('click', (event) => {
            if (!settingsPanel.classList.contains('open')) {
                return;
            }

            if (settingsPanel.contains(event.target) || settingsToggle.contains(event.target)) {
                return;
            }

            toggleSettingsPanel(false);
        });

        volumeControl.addEventListener('input', (event) => {
            settingsState.volume = Number(event.target.value);
            applyVolume(settingsState.volume);
            persistSettings();
        });

        brightnessControl.addEventListener('input', (event) => {
            settingsState.brightness = Number(event.target.value);
            applyBrightness(settingsState.brightness);
            persistSettings();
        });

        themeControl.addEventListener('change', (event) => {
            settingsState.theme = event.target.value;
            applyTheme(settingsState.theme);
            persistSettings();
        });

        loadSettings();

        const canvas = document.getElementById('fluidBg');
        const ctx = canvas.getContext('2d');
        let width = 0;
        let height = 0;
        let t = 0;

        const blobs = [
            { x: 0.2, y: 0.25, r: 0.28, vx: 0.0006, vy: 0.00045, color: '239,68,68' },
            { x: 0.72, y: 0.28, r: 0.24, vx: -0.0005, vy: 0.00038, color: '59,130,246' },
            { x: 0.55, y: 0.78, r: 0.3, vx: 0.00035, vy: -0.00045, color: '250,204,21' },
        ];

        function resizeCanvas() {
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = Math.floor(width * window.devicePixelRatio);
            canvas.height = Math.floor(height * window.devicePixelRatio);
            canvas.style.width = `${width}px`;
            canvas.style.height = `${height}px`;
            ctx.setTransform(window.devicePixelRatio, 0, 0, window.devicePixelRatio, 0, 0);
        }

        function drawFluid() {
            t += 0.01;
            ctx.clearRect(0, 0, width, height);

            const bgGrad = ctx.createLinearGradient(0, 0, width, height);
            bgGrad.addColorStop(0, '#091123');
            bgGrad.addColorStop(0.5, '#111f44');
            bgGrad.addColorStop(1, '#1c0f2d');
            ctx.fillStyle = bgGrad;
            ctx.fillRect(0, 0, width, height);

            blobs.forEach((blob, i) => {
                blob.x += blob.vx + Math.sin(t * (0.8 + i * 0.2)) * 0.00045;
                blob.y += blob.vy + Math.cos(t * (0.7 + i * 0.25)) * 0.00035;

                if (blob.x < 0.05 || blob.x > 0.95) blob.vx *= -1;
                if (blob.y < 0.05 || blob.y > 0.95) blob.vy *= -1;

                const px = blob.x * width;
                const py = blob.y * height;
                const rad = Math.min(width, height) * blob.r;

                const grad = ctx.createRadialGradient(px, py, rad * 0.06, px, py, rad);
                grad.addColorStop(0, `rgba(${blob.color},0.4)`);
                grad.addColorStop(0.56, `rgba(${blob.color},0.14)`);
                grad.addColorStop(1, `rgba(${blob.color},0)`);

                ctx.fillStyle = grad;
                ctx.beginPath();
                ctx.arc(px, py, rad, 0, Math.PI * 2);
                ctx.fill();
            });

            ctx.strokeStyle = 'rgba(255,255,255,0.04)';
            ctx.lineWidth = 1;
            const gridStep = 40;

            for (let x = 0; x < width; x += gridStep) {
                ctx.beginPath();
                const sway = Math.sin((x + t * 220) * 0.012) * 7;
                ctx.moveTo(x + sway, 0);
                ctx.lineTo(x + sway, height);
                ctx.stroke();
            }

            requestAnimationFrame(drawFluid);
        }

        window.addEventListener('resize', resizeCanvas);
        window.addEventListener('resize', () => {
            if (state.gameState === 'fight') {
                resizeFightCanvas();
            }
        });
        resizeCanvas();
        drawFluid();
    </script>
</body>
</html>
