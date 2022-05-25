import { useContext, useState } from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { useRegisterMutation } from "../../data/authenticationAPI";

const Registerblury__modal = () => {
    const { setModal, setActiveUser } = useContext(AppContext);

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
        usr_pass_conf: "",
    });
    const [register] = useRegisterMutation();

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

        const { usr_password, usr_pass_conf } = inputs;

        if (usr_password !== usr_pass_conf) {
            setFormErrors({
                ...formErrors,
                usr_pass_conf: "Passwords don't match",
            });
            return;
        }

        const { data, error } = await register(inputs);

        if (data) {
            localStorage.setItem("usr_name", data.usr_name);
            localStorage.setItem("usr_id", data.usr_id);
            localStorage.setItem("csrf", data.csrf);
            setInputs({});
            setModal(null);
        } else if (error) {
            setFormErrors({ ...formErrors, ...error.data });
        }
    }

    return (
        <BaseModal>
            <h1 className="modal__title">Register</h1>
            <form className="modal__input" onSubmit={submitHandler}>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        value={inputs.usr_name}
                        placeholder="Enter first name"
                        name="usr_name"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__input__item__error">
                        {formErrors.usr_name}
                    </p>
                </div>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon2" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        value={inputs.usr_lastname}
                        placeholder="Enter name"
                        name="usr_lastname"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__input__item__error">
                        {formErrors.usr_lastname}
                    </p>
                </div>
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="input"
                        value={inputs.usr_email}
                        placeholder="Enter email"
                        name="usr_email"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__input__item__error">
                        {formErrors.usr_email}
                    </p>
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        value={inputs.usr_password}
                        name="usr_password"
                        placeholder="Enter password"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__input__item__error">
                        {formErrors.usr_password}
                    </p>
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        value={inputs.usr_pass_conf}
                        name="usr_pass_conf"
                        placeholder="Enter password"
                        onChange={handleInputChange}
                        required
                    />
                    <p className="modal__input__item__error">
                        {formErrors.usr_pass_conf}
                    </p>
                </div>
                <button className="modal__btn">Register</button>
            </form>
            <p className="modal__link">
                You already have an account? Go to{" "}
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
