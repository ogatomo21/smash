const getYMD = isClock => {
    const one2 = (num) => (num <= 9 ? `0${num}` : num);
    const dayJapanese = ['日', '月', '火', '水', '木', '金', '土'];

    const now = new Date();
    const yy = now.getFullYear();
    const mm = one2(now.getMonth()+1);
    const dd = one2(now.getDate());
    const h = one2(now.getHours());
    const m = one2(now.getMinutes());
    const day = dayJapanese[now.getDay()];

    return isClock ? `${h}:${m}` : `${yy}年${mm}月${dd}日(${day})`;
}

const updateTime = (clock, dateYMD) => {
    clock.textContent = getYMD(true);
    dateYMD.textContent = getYMD(false);
}

const getWeather = async (weather, weatherImg) => {
    const url = '/api/jma_weather.php';
    const res = await fetch(url);
    const data = await res.json();
    console.log(data);
    weather.textContent = data.weather_text;
    weatherImg.src = data.weather_image;
};

const getSBTemperature = async (temperature, humidity) => {
    const url = '/api/temperature.php';
    const res = await fetch(url);
    const data = await res.json();
    console.log(data);
    temperature.textContent = data.temperature + '℃';
    humidity.textContent = data.humidity + '%';
}

const sendSBCommand = async (device, action, button) => {
    const url = `/api/action.php?device=${device}&action=${action}`;
    const beforeText = button.textContent;

    button.disabled = true;
    button.classList.add('is-loading');

    try {
        const res = await fetch(url);
        const data = await res.json();
        console.log(data);

        button.classList.remove('is-loading');
        if(data.message === 'success'){
            button.textContent = '✅️Success!';
        } else {
            button.textContent = '❌Failed';
        }
    } catch (e) {
        console.error(e);
        button.textContent = '❌Error';
    }

    setTimeout(() => {
        button.textContent = beforeText;
        button.disabled = false;
    }, 2000);
};




document.addEventListener('DOMContentLoaded', () => {
    const clock = document.getElementById('clock'); 
    const dateYMD = document.getElementById('date-ymd');
    const weather = document.getElementById('weather');
    const weatherImg = document.getElementById('weather-img');
    const temperature = document.getElementById('room-temperature');
    const humidity = document.getElementById('room-humidity');

    const lockLock = document.getElementById('lock-lock');
    const lockUnlock = document.getElementById('lock-unlock');
    const acCool = document.getElementById('ac-cool');
    const acHeat = document.getElementById('ac-heat');
    const acOff = document.getElementById('ac-off');
    const lightOn = document.getElementById('light-on');
    const lightOff = document.getElementById('light-off');

    setInterval(updateTime, 500, clock, dateYMD); // 0.5 sec
    setInterval(getWeather, 10 * 60 * 1000, weather, weatherImg); // 10 min
    setInterval(getSBTemperature, 10 * 60 * 1000, temperature, humidity); // 10 min
    updateTime(clock, dateYMD);
    getWeather(weather, weatherImg);
    getSBTemperature(temperature, humidity);

    lockLock.addEventListener('click', sendSBCommand.bind(this, 'lock', 'lock', lockLock));
    lockUnlock.addEventListener('click', () => {
        if(confirm('本当に解錠(アンロック)しますか？')){
            sendSBCommand('lock', 'unlock', lockUnlock);
        }
    });
    acCool.addEventListener('click', sendSBCommand.bind(this, 'ac', 'cool', acCool));
    acHeat.addEventListener('click', sendSBCommand.bind(this, 'ac', 'heat', acHeat));
    acOff.addEventListener('click', sendSBCommand.bind(this, 'ac', 'turnOff', acOff));
    lightOn.addEventListener('click', sendSBCommand.bind(this, 'light', 'turnOn', lightOn));
    lightOff.addEventListener('click', sendSBCommand.bind(this, 'light', 'turnOff', lightOff));
});
