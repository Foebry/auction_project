import { useContext, useState } from "react";
import { MdLockOutline, MdOutlineAlternateEmail } from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { usePostLoginMutation } from "../../data/authenticationAPI";

const Loginblury__modal = () => {
    const { setModal, setActiveUser } = useContext(AppContext);
    const [inputs, setInputs] = useState({
        usr_email: "",
        usr_password: "",
    });
    const [login] = usePostLoginMutation();

    const handleInputChange = (e) => {
        setInputs({
            ...inputs,
            [e.target.name]: e.target.value,
        });
    };

    async function submitHandler(e) {
        e.preventDefault();

        const usr_email = inputs.email;
        const usr_password = inputs.password;
        const { data, error } = await login({
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
            <h1 className="modal__title">Login</h1>
            <form onSubmit={submitHandler} className="modal__input">
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
                <button className="modal__btn">Login</button>
            </form>
            <p className="modal__link">
                Don't have an account yet?{" "}
                <button
                    className="modal__link__btnTo"
                    onClick={() => {
                        setModal("register");
                    }}
                >
                    Register
                </button>
            </p>
        </BaseModal>
    );
};
export default Loginblury__modal;
