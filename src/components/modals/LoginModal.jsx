import { useContext, useState } from "react";
import { useNavigate } from "react-router";
import { MdLockOutline, MdOutlineAlternateEmail } from "react-icons/md";
import BaseModal from "./baseModal";
import { AppContext } from "../../context/AppContext";
import { useLoginMutation } from "../../data/authenticationAPI";
import { ADMIN } from "../../types/RouteTypes";

const Loginblury__modal = () => {
    const navigate = useNavigate();
    const { setModal, onClose } = useContext(AppContext);
    const [inputs, setInputs] = useState({
        usr_email: "",
        usr_password: "",
    });
    const [formErrors, setFormErrors] = useState({
        usr_email: "",
        usr_password: "",
    });
    const [login] = useLoginMutation();

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

        const { data, error } = await login(inputs);
        if (data) {
            localStorage.setItem("usr_name", data.usr_name);
            localStorage.setItem("usr_id", data.usr_id);
            localStorage.setItem("csrf", data.csrf);
            localStorage.setItem("usr_isAdmin", data.usr_isAdmin);
            setInputs({});
            setModal(null);
            data.usr_isAdmin && navigate(ADMIN);
        } else if (error) {
            setFormErrors({ ...formErrors, ...error.data });
        }
    }
    return (
        <BaseModal onClose={onClose}>
            <h1 className="modal__title">Login</h1>
            <form onSubmit={submitHandler} className="modal__input">
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
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
