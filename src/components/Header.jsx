import { useContext } from "react";
import { AppContext } from "../context/AppContext";

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
                            <button
                                className="link"
                                onClick={() => setModal("login")}
                            >
                                Login
                            </button>
                            <button
                                className="link"
                                onClick={() => setModal("register")}
                            >
                                Register
                            </button>
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
                            <button
                                className="link"
                                onClick={() => setModal("userproducts")}
                            >
                                My Products
                            </button>
                            <button className="link" onClick={handleLogout}>
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
