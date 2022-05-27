import { useContext } from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { useGetCurrentUserQuery } from "../../data/userAPI";

const Userblury__modal = () => {
    const { setModal } = useContext(AppContext);
    const { data, isError, isLoading } = useGetCurrentUserQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });
    return (
        <BaseModal>
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
