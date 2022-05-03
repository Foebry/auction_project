import { useEffect, useState } from "react";

const Timer = ({ rest }) => {
    const [time, setTime] = useState(rest - Date.now());

    let h = Math.floor(time / 360000);
    let m = Math.floor((time % 360000) / 6000);
    let s = Math.floor((time % 360000) % 6000);

    useEffect(() => {
        const timerId = setInterval(() => {
            setTime((prevCounter) => -Date.now());
        }, 1000);

        if (h == 0 && m == 0 && s == 0) {
            clearInterval(timerId);
        }

        return () => {
            clearInterval(timerId);
        };
    }, [time]);

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
