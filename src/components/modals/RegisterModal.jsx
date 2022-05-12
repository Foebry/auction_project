import React from "react";
import { Link } from "react-router-dom";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import { Routes } from "../../types/RouteTypes";

const RegisterModal = ({ closeRegister }) => {
    return (
        <div className="modalBackground">
            <div className="modalBackground__modalContainer">
                <div className="modalBackground__modalContainer__closeBtn">
                    <button onClick={() => closeRegister(false)}>X</button>
                </div>
                <h1 className="modalBackground__modalContainer__title">
                    Register
                </h1>
                <div className="modalBackground__modalContainer__input">
                    <div className="modalBackground__modalContainer__input__item">
                        <MdPersonOutline className="modalBackground__modalContainer__input__item__icon" />
                        <input
                            className="modalBackground__modalContainer__input__item__inputfield"
                            type="text"
                            placeholder="Enter first name"
                            name="firstname"
                            required
                        />
                    </div>
                    <div className="modalBackground__modalContainer__input__item">
                        <MdPersonOutline className="modalBackground__modalContainer__input__item__icon2" />
                        <input
                            className="modalBackground__modalContainer__input__item__inputfield"
                            type="text"
                            placeholder="Enter name"
                            name="name"
                            required
                        />
                    </div>
                    <div className="modalBackground__modalContainer__input__item">
                        <MdOutlineAlternateEmail className="modalBackground__modalContainer__input__item__icon" />
                        <input
                            className="modalBackground__modalContainer__input__item__inputfield"
                            type="email"
                            placeholder="Enter email"
                            name="email"
                            required
                        />
                    </div>
                    <div className="modalBackground__modalContainer__input__item">
                        <MdLockOutline className="modalBackground__modalContainer__input__item__icon" />
                        <input
                            className="modalBackground__modalContainer__input__item__inputfield"
                            type="password"
                            name="pwd"
                            placeholder="Enter password"
                            required
                        />
                    </div>
                </div>
                <button className="modalBackground__modalContainer__btn">
                    Login
                </button>
                <p>
                    Already have an account? Go to{" "}
                    <Link to={Routes.LOGIN}>Login</Link>
                </p>
            </div>
        </div>
    );
};

export default RegisterModal;
