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
            <h1 className="modal__title">My Details</h1>
            <div className="modal__input">
                <div className="modal__input__item">
                    <div className="modal__input__item__detail">
                        <MdPersonOutline className="modal__input__item__icon" />
                        <p>Voornaam</p>
                    </div>
                </div>
                <div className="modal__input__item">
                    <div className="modal__input__item__detail">
                        <MdPersonOutline className="modal__input__item__icon2" />
                        <p>Achternaam</p>
                    </div>
                </div>
                <div className="modal__input__item">
                    <div className="modal__input__item__detail">
                        <MdOutlineAlternateEmail className="modal__input__item__icon" />
                        <p>Email</p>
                    </div>
                </div>
                <div className="modal__input__item">
                    <div className="modal__input__item__detail">
                        <MdLockOutline className="modal__input__item__icon" />
                        <p> ***********</p>
                    </div>
                </div>
            </div>
            <button
                className="modal__btn"
                onClick={() => {
                    setModal("edit");
                }}
            >
                Change
            </button>
            <p className="modal__link"></p>
        </BaseModal>
    );
};

export default Registerblury__modal;
