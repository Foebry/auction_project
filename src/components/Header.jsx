import { Link } from "react-router-dom";
import { useContext } from "react";
import { AppContext } from "../context/AppContext";
import { Routes } from "../types/RouteTypes";

const Header = () => {
    const { setModal, handleLogout } = useContext(AppContext);
    const name = localStorage.getItem("usr_name");

    return (
        <header className="header container">
            <div className="header__items container__medium">
                <h1 className="header__items__text">
                    <span>OneClick</span> Pirate
                </h1>
                <div className="header__items__links">
                    {!name && (
                        <>
                            <Link
                                className="link"
                                to={Routes.LOGIN}
                                onClick={() => setModal("login")}
                            >
                                Login
                            </Link>
                            <Link
                                className="link"
                                to={Routes.REGISTER}
                                onClick={() => setModal("register")}
                            >
                                Register
                            </Link>
                        </>
                    )}
                    {name && (
                        <>
                            <p>
                                Welcome{" "}
                                <span
                                    className="modal__link__btnTo"
                                    onClick={() => {
                                        setModal("user");
                                    }}
                                >
                                    {name}
                                </span>
                            </p>
                            <Link
                                className="link"
                                to={Routes.USER_PRODUCTS}
                                onClick={() => setModal("userproducts")}
                            >
                                My Products
                            </Link>
                            <Link
                                className="link"
                                to={"#"}
                                onClick={handleLogout}
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
