import { useContext } from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";

const Registerblury__modal = () => {
    const { setModal } = useContext(AppContext);

    return (
        <BaseModal>
            <h1 className="modal__title">Register</h1>
            <div className="modal__input">
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        placeholder="Enter first name"
                        name="firstname"
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon2" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        placeholder="Enter name"
                        name="name"
                        required
                    />
                </div>
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
            </div>
            <button className="modal__btn">Register</button>
            <p className="modal__link">
                Already have an account? Go to{" "}
                <button
                    className="modal__link__btnTo"
                    onClick={() => {
                        setModal("login");
                    }}
                >
                    Login
                </button>
            </p>
        </BaseModal>
    );
};

export default Registerblury__modal;
