import { Link } from "react-router-dom";
import { useContext } from "react";
import { AppContext } from "../context/AppContext";
import { Routes } from "../types/RouteTypes";

const Header = () => {
    const { setModal } = useContext(AppContext);
    const usr_name = localStorage.getItem("usr_name");

    const logout = () => {
        localStorage.removeItem("usr_name");
        reload();
    };

    return (
        <header className="header container">
            <div className="header__items container__medium">
                <h1 className="header__items__text">
                    <span>OneClick</span> Pirate
                </h1>
                <div className="header__items__links">
                    {!usr_name && (
                        <>
                            <button
                                className="btn"
                                onClick={() => setModal("login")}
                            >
                                Login
                            </button>
                            <button
                                className="btn"
                                onClick={() => setModal("register")}
                            >
                                Register
                            </button>
                        </>
                    )}
                    {usr_name && (
                        <>
                            <p>
                                Welcome{" "}
                                <span>{localStorage.getItem("usr_name")}</span>
                            </p>
                            <button className="btn">My Products</button>
                            <button className="btn" onClick={logout}>
                                Logout
                            </button>
                        </>
                    )}
                </div>
            </div>
        </header>
    );
};

export default Header;
