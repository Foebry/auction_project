import { useEffect, useState } from "react";
import moment from "moment";

const Timer = () => {
    const currentDate = moment();
    const future = moment("2022-04-29 12:00:00");
    const timeLeft = moment(future.diff(currentDate)).format("HH:mm:ss");

    const [time, setTime] = useState(timeLeft);

    useEffect(() => {
        const timerId = setInterval(() => {
            setTime(timeLeft);
        }, 1000);

        return () => {
            clearInterval(timerId);
        };
    });

    return <div className="timer">{time}</div>;
};

export default Timer;
