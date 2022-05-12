import { Link } from "react-router-dom";
import { useContext, useState } from "react";
import { AppContext } from "../context/AppContext";
import { Routes } from "../types/RouteTypes";
import LoginModal from "./modals/LoginModal";
import RegisterModal from "./modals/RegisterModal";

const Header = () => {
    const { userId, setUserId } = useContext(AppContext);
    const [openLogin, setOpenLogin] = useState(false);
    const [openRegister, setOpenRegister] = useState(false);

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
                                to={Routes.LOGIN}
                                onClick={() => setOpenLogin(true)}
                            >
                                Login
                            </Link>
                            {openLogin && (
                                <LoginModal closeLogin={setOpenLogin} />
                            )}
                            <Link
                                className="link"
                                to={Routes.REGISTER}
                                onClick={() => setOpenRegister(true)}
                            >
                                Register
                            </Link>
                            {openRegister && (
                                <RegisterModal
                                    closeRegister={setOpenRegister}
                                />
                            )}
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
