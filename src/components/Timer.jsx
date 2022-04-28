import { useEffect, useState } from "react";

const Timer = () => {
  const [time, setTime] = useState(20);

  let h = Math.floor(time / 3600);
  let m = Math.floor((time % 3600) / 60);
  let s = Math.floor((time % 3600) % 60);

  useEffect(() => {
    const timerId = setInterval(() => {
      setTime((prevCounter) => prevCounter - 1);
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
    <div>
      {h}:{m}:{s}
    </div>
  );
};

export default Timer;
