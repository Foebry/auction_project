import { useContext } from "react";
import { MdOutlineAlternateEmail, MdPersonOutline } from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { useGetCurrentUserQuery } from "../../data/userAPI";

const Userblury__modal = () => {
    const { setModal, onClose, setUpdateUser } = useContext(AppContext);
    const { data } = useGetCurrentUserQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });
    return (
        <BaseModal onClose={onClose}>
            <h1 className="modal__title">My Details</h1>
            <div className="modal__input">
                <div className="modal__input__item">
                    <div className="modal__input__item__detail">
                        <MdPersonOutline className="modal__input__item__icon" />
                        {data && <p>{data.usr_name}</p>}
                    </div>
                </div>
                <div className="modal__input__item">
                    <div className="modal__input__item__detail">
                        <MdPersonOutline className="modal__input__item__icon2" />
                        {data && <p>{data.usr_lastname}</p>}
                    </div>
                </div>
                <div className="modal__input__item">
                    <div className="modal__input__item__detail">
                        <MdOutlineAlternateEmail className="modal__input__item__icon" />
                        {data && <p>{data.usr_email}</p>}
                    </div>
                </div>
            </div>
            <button
                className="modal__btn"
                onClick={() => {
                    setUpdateUser(null);
                    setModal("edit");
                }}
            >
                Change
            </button>
            <p className="modal__link"></p>
        </BaseModal>
    );
};

export default Userblury__modal;
