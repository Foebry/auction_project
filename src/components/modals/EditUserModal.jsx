import { useContext, useEffect, useState, useMemo } from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import {
    usePatchCurrentUserMutation,
    useGetCurrentUserQuery,
} from "../../data/userAPI";

const EditUserblury__modal = () => {
    const { setModal } = useContext(AppContext);

    const { data: fetchData } = useGetCurrentUserQuery(undefined, {
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const userData = useMemo(() => fetchData, [fetchData]);

    const [formErrors, setFormErrors] = useState({
        usr_name: "",
        usr_lastname: "",
        usr_email: "",
        usr_password: "",
        usr_pass_verify: "",
    });

    const [inputs, setInputs] = useState({
        usr_name: "",
        usr_lastname: "",
        usr_email: "",
        usr_password: "",
        usr_pass_verify: "",
    });
    const [update] = usePatchCurrentUserMutation();

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

        if (usr_password && usr_pass_verify === "") {
            setFormErrors({
                ...formErrors,
                usr_pass_verify:
                    "To update your password, please enter your previous password first.",
            });

            return;
        }

        let newData = {};

        for (const [key, value] of Object.entries(inputs)) {
            if (value !== "") newData = { ...newData, [key]: value };
        }

        const { data: updateData, error } = await update(newData);

        if (updateData) {
            localStorage.setItem("usr_name", updateData.usr_name);
            setInputs({});
            setModal(null);
        } else if (error) {
            setFormErrors({ ...formErrors, ...error.data });
        }
    }

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
                        placeholder={userData.usr_name}
                        onChange={handleInputChange}
                        name="usr_name"
                    />
                    <p>{formErrors.usr_name}</p>
                </div>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon2" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        value={inputs.usr_lastname}
                        placeholder={userData.usr_lastname}
                        onChange={handleInputChange}
                        name="usr_lastname"
                    />
                    <p>{formErrors.usr_lastname}</p>
                </div>
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        value={inputs.usr_email}
                        placeholder={userData?.usr_email ?? "email"}
                        onChange={handleInputChange}
                        name="usr_email"
                    />
                    <p>{formErrors.usr_email}</p>
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
                    <p>{formErrors.usr_password}</p>
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
                <p>{formErrors.usr_pass_verify}</p>
                <button className="modal__btn">Edit</button>
            </form>
            <p className="modal__link"></p>
        </BaseModal>
    );
};

export default EditUserblury__modal;
