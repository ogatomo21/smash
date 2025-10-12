<?php
$_SMASH_VERSION = '1.2';
?>
<!DOCTYPE html>
<?php
function defaultMode()
{
    if (getenv('AUTO_DARK_MODE') === 'true') {
        $hour = date('H');
        $startHour = intval(getenv('DARK_START_HOUR'));
        $endHour = intval(getenv('DARK_END_HOUR'));
        if ($startHour < $endHour) {
            if ($hour >= $startHour && $hour < $endHour) {
                return '<html lang="ja" data-theme="dark">';
            } else {
                if (getenv('DEFAULT_COLOR_MODE') == "dark") {
                    return '<html lang="ja" data-theme="dark">';
                } elseif (getenv('DEFAULT_COLOR_MODE') == "light") {
                    return '<html lang="ja" data-theme="light">';
                } elseif (getenv('DEFAULT_COLOR_MODE') == "auto") {
                    return '<html lang="ja">';
                } else {
                    return '<html lang="ja">';
                }
            }
        } else {
            if ($hour >= $startHour || $hour < $endHour) {
                return '<html lang="ja" data-theme="dark">';
            } else {
                if (getenv('DEFAULT_COLOR_MODE') == "dark") {
                    return '<html lang="ja" data-theme="dark">';
                } elseif (getenv('DEFAULT_COLOR_MODE') == "light") {
                    return '<html lang="ja" data-theme="light">';
                } elseif (getenv('DEFAULT_COLOR_MODE') == "auto") {
                    return '<html lang="ja">';
                } else {
                    return '<html lang="ja">';
                }
            }
        }
    } else {
        if (getenv('DEFAULT_COLOR_MODE') == "dark") {
            return '<html lang="ja" data-theme="dark">';
        } elseif (getenv('DEFAULT_COLOR_MODE') == "light") {
            return '<html lang="ja" data-theme="light">';
        } elseif (getenv('DEFAULT_COLOR_MODE') == "auto") {
            return '<html lang="ja">';
        } else {
            return '<html lang="ja">';
        }
    }
}
if (isset($_GET["mode"])) {
    $mode = $_GET["mode"];
    if ($mode == "dark") {
        echo '<html lang="ja" data-theme="dark">';
    } elseif ($mode == "light") {
        echo '<html lang="ja" data-theme="light">';
    } elseif ($mode == "auto") {
        echo '<html lang="ja">';
    } else {
        echo defaultMode();
    }
} else {
    echo defaultMode();
}
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SMASH v<?php echo htmlspecialchars($_SMASH_VERSION); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/1.0.4/css/bulma.min.css"
        integrity="sha512-yh2RE0wZCVZeysGiqTwDTO/dKelCbS9bP2L94UvOFtl/FKXcNAje3Y2oBg/ZMZ3LS1sicYk4dYVGtDex75fvvA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+JP:wght@400;500&family=Jost:wght@400;500&display=swap"
        rel="stylesheet">
    <script src="/assets/main.js"></script>

    <style>
        body {
            font-family: 'IBM Plex Sans JP', sans-serif;
        }

        .clock-container {
            font-size: 7rem;
            line-height: 1;
            text-align: center;
            font-family: "Jost", sans-serif;
            font-weight: 500;
        }

        .date-container {
            font-size: 2rem;
            text-align: center;
            font-weight: 500;
        }

        .weather-container {
            font-size: 2rem;
            font-weight: 500;
        }

        #temperature {
            font-family: "Jost", sans-serif;
            font-weight: 400;
        }

        .room-temperature-container,
        .room-humidity-container {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            font-family: "Jost", sans-serif;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <div class="app m-5">
        <div class="columns">
            <div class="column is-half">
                <div class="box p-6">
                    <div
                        class="is-flex is-justify-content-center is-align-items-center is-flex-wrap-wrap has-text-centered" style="gap: 0 2rem;">
                        <div class="clock-container">
                            <span id="clock">
                                --:--
                            </span>
                        </div>
                        <div
                            class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center has-text-centered is-flex-wrap-wrap">
                            <div class="date-container">
                                <span id="date-ymd">
                                    2024年01月01日(月)
                                </span>
                            </div>
                            <div
                                class="weather-container is-flex is-align-items-center is-justify-content-center is-flex-wrap-wrap has-text-centered">
                                <img id="weather-img" src="">
                                <span id="weather" class="ml-0 mr-6">Loading...</span>
                                <!-- <span class="icon">
                                    <i class="fa-solid fa-temperature-three-quarters has-text-danger"></i>
                                </span>
                                <span id="temperature" class="ml-3">25.0℃</span> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box p-5">
                    <div class="is-flex is-justify-content-center is-align-items-center is-flex-wrap-wrap">
                        <div class="room-temperature-container mr-6">
                            <span class="icon">
                                <i class="fa-solid fa-temperature-three-quarters has-text-danger"></i>
                            </span>
                            <span id="room-temperature" class="ml-3">--.-°C</span>
                        </div>
                        <div class="room-humidity-container">
                            <span class="icon">
                                <i class="fa-solid fa-droplet has-text-info"></i>
                            </span>
                            <span id="room-humidity" class="ml-3">50%</span>
                        </div>
                    </div>
                </div>
                <div class="box p-5">
                    <h2 class="title">ロック操作</h2>
                    <div class="buttons are-medium">
                        <button id="lock-lock" class="button is-link">
                            <span class="icon">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <span>
                                施錠(ロック)
                            </span>
                        </button>
                        <button id="lock-unlock" class="button is-danger has-text-white">
                            <span class="icon">
                                <i class="fa-solid fa-lock-open"></i>
                            </span>
                            <span>解錠(アンロック)</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="column is-half">
                <div class="box p-5">
                    <h2 class="title">エアコン</h2>
                    <div class="buttons">
                        <button id="ac-cool" class="button is-link is-large">
                            <span class="icon">
                                <i class="fa-solid fa-wind"></i>
                            </span>
                            <span>冷房28℃</span>
                        </button>
                        <button id="ac-heat" class="button is-danger has-text-white is-large">
                            <span class="icon">
                                <i class="fa-solid fa-mug-hot"></i>
                            </span>
                            <span>暖房20℃</span>
                        </button>
                        <button id="ac-off" class="button is-light is-large">
                            <span class="icon">
                                <i class="fa-solid fa-power-off"></i>
                            </span>
                            <span>エアコンOFF</span>
                        </button>
                    </div>
                </div>
                <div class="box p-5">
                    <h2 class="title">照明</h2>
                    <div class="buttons">
                        <button id="light-on" class="button is-link is-large">
                            <span class="icon">
                                <i class="fa-solid fa-bolt-lightning"></i>
                            </span>
                            <span>照明ON</span>
                        </button>
                        <button id="light-off" class="button is-light is-large">
                            <span class="icon">
                                <i class="fa-solid fa-power-off"></i>
                            </span>
                            <span>照明OFF</span>
                        </button>
                    </div>
                </div>
                <div class="box p-5">
                    <h2 class="title">シーン実行</h2>
                    <div id="scenes" class="buttons">
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
