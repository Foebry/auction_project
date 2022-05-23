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
    const { setModal } = useContext(AppContext);
    const [register] = usePostRegisterMutation();

    const [inputs, setInputs] = useState({
        usr_name: "",
        usr_lastname: "",
        usr_email: "",
        usr_password: "",
    });

    const onChange = (e) => {
        setInputs({ ...inputs, [e.target.name]: e.target.value });
    };

    const onSubmit = async (e) => {
        e.preventDefault();
        const { data, error } = await register(inputs);

        if (data) {
            localStorage.setItem("usr_name", data.usr_name);
            localStorage.setItem("usr_id", data.usr_id);
            localStorage.setItem("csrf", data.csrf);

            setInputs({
                usr_name: "",
                usr_lastname: "",
                usr_email: "",
                usr_password: "",
            });

            setModal(null);
        }
    };

    return (
        <BaseModal>
            <h1 className="modal__title">Register</h1>
            <form className="modal__input" onSubmit={onSubmit}>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        placeholder="Enter first name"
                        name="usr_name"
                        required
                        value={inputs.firstname}
                        onChange={onChange}
                    />
                </div>
                <div className="modal__input__item">
                    <MdPersonOutline className="modal__input__item__icon2" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        placeholder="Enter name"
                        name="usr_lastname"
                        required
                        value={inputs.lastname}
                        onChange={onChange}
                    />
                </div>
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="text"
                        placeholder="Enter email"
                        name="usr_email"
                        required
                        value={inputs.email}
                        onChange={onChange}
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
                        value={inputs.password}
                        onChange={onChange}
                    />
                </div>
                <button className="modal__btn">Register</button>
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
