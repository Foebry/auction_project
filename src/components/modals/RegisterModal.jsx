import { useContext, useState } from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";

const Registerblury__modal = () => {
    const { setModal } = useContext(AppContext);
    const [inputs, setInputs] = useState({});

    const handleInputChange = (e) => {
        setInputs({
            ...inputs,
            [e.target.name]: e.target.value,
        });
    };
    //console.log("inputs:", inputs);

    const submitHandler = (e) => {
        e.preventDefault();
        //console.log("inputs:", inputs);
    };

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
                <button type="submit" className="modal__btn">
                    Register
                </button>
            </form>
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
