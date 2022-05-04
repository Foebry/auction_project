import { useEffect, useState } from "react";
import moment from "moment";

const Timer = ({ rest }) => {
    const currentDate = moment().add(1, "hour");
    const future = moment(rest);
    const timeLeft = moment(future.diff(currentDate)).format("HH:mm:ss");
    // console.log(expiration);

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
