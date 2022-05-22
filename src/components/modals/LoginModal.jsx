import { useContext, useState } from "react";
import { MdLockOutline, MdOutlineAlternateEmail } from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { usePostLoginMutation } from "../../data/authenticationAPI";

const Loginblury__modal = () => {
    const { setModal } = useContext(AppContext);
    const [login] = usePostLoginMutation();

    const [usr_email, setEmail] = useState("");
    const [usr_password, setPassword] = useState("");

    const onSubmit = async (e) => {
        e.preventDefault();
        const { data, error } = await login({ usr_email, usr_password });

        if (data) {
            localStorage.setItem("usr_name", data.usr_name);
            setEmail("");
            setPassword("");
            setModal(null);
        }
    };

    const handleEmailChange = (e) => setEmail(e.target.value);
    const handlePasswordChange = (e) => setPassword(e.target.value);

    return (
        <BaseModal>
            <h1 className="modal__title">Login</h1>
            <form className="modal__input" onSubmit={onSubmit}>
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="email"
                        placeholder="Enter email"
                        name="usr_email"
                        required
                        value={usr_email}
                        onChange={handleEmailChange}
                    />
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        name="usr_password"
                        placeholder="Enter password"
                        required
                        value={usr_password}
                        onChange={handlePasswordChange}
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
