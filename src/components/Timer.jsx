import { useEffect, useState } from "react";
import moment from "moment";

const Timer = () => {
    const currentDate = moment().add(1, "hour");
    const future = moment("2022-04-29 12:19:00");
    const timeLeft = moment(future.diff(currentDate)).format("HH:mm:ss");

    const [time, setTime] = useState(timeLeft);

    useEffect(() => {
        const timerId = setInterval(() => {
            setTime(timeLeft);
        }, 1000);

        if (timeLeft == "00:00:00") {
            clearInterval(timerId);
        }

        return () => {
            clearInterval(timerId);
        };
    });

    return <div className="timer">{time}</div>;
};

export default Timer;
