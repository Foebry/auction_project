import { Link } from "react-router-dom";
import { useContext } from "react";
import { AppContext } from "../context/AppContext";

const Header = () => {
    const { userId, setUserId } = useContext(AppContext);

    return (
        <header className="header container">
            <div className="header__items container__medium">
                <h1 className="header__items__text">
                    <span>OneClick</span> Pirate
                </h1>
                <div className="header__items__links">
                    {!userId && (
                        <>
                            <Link
                                className="link"
                                to={"#"}
                                onClick={() => setUserId(52)}
                            >
                                Login
                            </Link>
                            <Link className="link" to={"#"}>
                                Register
                            </Link>
                        </>
                    )}
                    {userId && (
                        <>
                            <p>
                                Welcome <span>NAME</span>
                            </p>
                            <Link className="link" to={"#"}>
                                My Products
                            </Link>
                            <Link
                                className="link"
                                to={"#"}
                                onClick={() => setUserId(undefined)}
                            >
                                Logout
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </header>
    );
};

export default Header;
