import { useContext, useState } from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { usePostRegisterMutation } from "../../data/authenticationAPI";

const Registerblury__modal = () => {
    const { setModal, setActiveUser } = useContext(AppContext);
    const [inputs, setInputs] = useState({
        usr_name: "",
        usr_lastname: "",
        usr_email: "",
        usr_password: "",
    });
    const [register] = usePostRegisterMutation();

    const handleInputChange = (e) => {
        setInputs({
            ...inputs,
            [e.target.name]: e.target.value,
        });
    };

    async function submitHandler(e) {
        e.preventDefault();

        const usr_name = inputs.firstName;
        const usr_lastname = inputs.lastName;
        const usr_email = inputs.email;
        const usr_password = inputs.password;
        const { data, error } = await register({
            usr_name,
            usr_lastname,
            usr_email,
            usr_password,
        });
        if (data) {
            localStorage.setItem("usr_name", data.usr_name);
            localStorage.setItem("usr_id", data.usr_id);
            localStorage.setItem("csrf", data.csrf);
            setInputs({});
            setModal(null);
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
                        value={inputs.firstName}
                        placeholder="Enter first name"
                        name="firstName"
                        onChange={handleInputChange}
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon2" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        value={inputs.lastName}
                        placeholder="Enter name"
                        name="lastName"
                        onChange={handleInputChange}
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="email"
                        value={inputs.email}
                        placeholder="Enter email"
                        name="email"
                        onChange={handleInputChange}
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        value={inputs.password}
                        name="password"
                        placeholder="Enter password"
                        onChange={handleInputChange}
                        required
                    />
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
