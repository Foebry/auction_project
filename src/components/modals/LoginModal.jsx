import React from "react";
import { Link } from "react-router-dom";
import { MdLockOutline, MdOutlineAlternateEmail } from "react-icons/md";
import { Routes } from "../../types/RouteTypes";

const LoginModal = ({ closeLogin }) => {
    return (
        <div className="modalBackground">
            <div className="modalBackground__modalContainer">
                <div className="modalBackground__modalContainer__closeBtn">
                    <button onClick={() => closeLogin(false)}>X</button>
                </div>
                <h1 className="modalBackground__modalContainer__title">
                    Login
                </h1>
                <div className="modalBackground__modalContainer__input">
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
                    Don't have an account yet?{" "}
                    <Link to={Routes.REGISTER}>Register</Link>
                </p>
            </div>
        </div>
    );
};

export default LoginModal;
