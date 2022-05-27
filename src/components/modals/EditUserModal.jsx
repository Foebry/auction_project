import { useContext, useState } from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { usePatchCurrentUserMutation } from "../../data/userAPI";
import { useGetCurrentUserQuery } from "../../data/userAPI";

const EditUserblury__modal = () => {
    const { setModal } = useContext(AppContext);
    const { modal } = useContext(AppContext);
    const { data } = useGetCurrentUserQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const [formErrors, setFormErrors] = useState({
        usr_name: "",
        usr_lastname: "",
        usr_email: "",
        usr_password: "",
        usr_pass_conf: "",
    });

    const [inputs, setInputs] = useState({
        usr_name: "",
        usr_lastname: "",
        usr_email: "",
        usr_password: "",
        usr_pass_verify: "",
    });
    const [register] = usePatchCurrentUserMutation();

    const handleInputChange = (e) => {
        setInputs({
            ...inputs,
            [e.target.name]: e.target.value,
        });
        setFormErrors({
            ...formErrors,
            [e.target.name]: "",
        });
    };

    async function submitHandler(e) {
        e.preventDefault();

        const { usr_password, usr_pass_verify } = inputs;

        if (usr_password !== usr_pass_verify) {
            setFormErrors({
                ...formErrors,
                usr_pass_conf: "Passwords don't match",
            });
            return;
        }

        const { data, error } = await register(inputs);

        if (data) {
            localStorage.setItem("usr_name", data.usr_name);
            setInputs({});
            setModal(null);
        } else if (error) {
            setFormErrors({ ...formErrors, ...error.data });
        }
    }
    console.log({ modal });
    return (
        <BaseModal>
            <h1 className="modal__title">Change my Details</h1>
            <form className="modal__input" onSubmit={submitHandler}>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        value={inputs.usr_name}
                        placeholder={data?.usr_name}
                        onChange={handleInputChange}
                        name="usr_name"
                    />
                </div>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon2" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        value={inputs.usr_lastname}
                        placeholder={data?.usr_lastname}
                        onChange={handleInputChange}
                        name="usr_lastname"
                    />
                </div>
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="email"
                        value={inputs.usr_email}
                        placeholder={data?.usr_email}
                        onChange={handleInputChange}
                        name="usr_email"
                    />
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        name="usr_password"
                        value={inputs.usr_password}
                        placeholder="new password"
                        onChange={handleInputChange}
                    />
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        name="usr_pass_verify"
                        value={inputs.usr_password_verify}
                        placeholder="old password"
                        onChange={handleInputChange}
                    />
                </div>
                <button className="modal__btn">Edit</button>
            </form>
            <p className="modal__link"></p>
        </BaseModal>
    );
};

export default EditUserblury__modal;
