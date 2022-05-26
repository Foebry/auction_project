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
            <h1 className="modal__title">Change my Details</h1>
            <div className="modal__input">
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        placeholder="Voornaam"
                        name="firstname"
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon2" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        placeholder="Achternaam"
                        name="name"
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="email"
                        placeholder="email"
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
                        placeholder="*********"
                        required
                    />
                </div>
            </div>
            <button className="modal__btn">Edit</button>
            <p className="modal__link"></p>
        </BaseModal>
    );
};

export default Registerblury__modal;
