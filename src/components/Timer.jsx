import { useEffect, useState } from "react";

const Timer = () => {
    const endDate = new Date("April 29, 2022 12:00:00");
    const [time, setTime] = useState(endDate / 1000);

    let now = Date.now();
    console.log(now);

    let h = Math.floor(time / 3600);
    let m = Math.floor((time % 3600) / 60);
    let s = Math.floor((time % 3600) % 60);

    useEffect(() => {
        const timerId = setInterval(() => {
            setTime(endDate - now);
        }, 1000);

        if (h == 0 && m == 0 && s == 0) {
            clearInterval(timerId);
        }

        return () => {
            clearInterval(timerId);
        };
    });

    if (h < 10) h = "0" + h;
    if (m < 10) m = "0" + m;
    if (s < 10) s = "0" + s;

    return (
        <div className="timer">
            {h}:{m}:{s}
        </div>
    );
};

export default Timer;
