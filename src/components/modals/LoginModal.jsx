import { useContext } from "react";
import { MdLockOutline, MdOutlineAlternateEmail } from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";

const Loginblury__modal = () => {
    const { setModal } = useContext(AppContext);

    return (
        <BaseModal>
            <h1 className="modal__title">Login</h1>
            <form className="modal__input">
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="email"
                        placeholder="Enter email"
                        name="email"
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        name="pwd"
                        placeholder="Enter password"
                        required
                    />
                </div>
            </form>
            <button className="modal__btn">Login</button>
            <p className="modal__link">
                Don't have an account yet?{" "}
                <button
                    className="modal__link__btnTo"
                    onClick={() => {
                        setModal("register");
                    }}
                >
                    Register
                </button>
            </p>
        </BaseModal>
    );
};

export default Loginblury__modal;
