import { useEffect, useState } from "react";
import moment from "moment";

const Timer = ({ rest }) => {
    const [timeLeft, setTimeLeft] = useState("00:00:00");

    const updateTime = () => {
        const currentTime = moment();
        const future = moment(rest);

        const diff = future - currentTime;

        if (diff > 0) {
            setTimeout(() => {
                const format = diff > 3600000 ? "hh:mm:ss" : "00:mm:ss";
                setTimeLeft(moment(diff).format(format));
            }, 1000);
        }
    };

    useEffect(() => {
        updateTime();
    }, [timeLeft]);

    return <div className="timer">{timeLeft}</div>;
};

export default Timer;
