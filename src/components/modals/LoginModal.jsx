import React from "react";
import { Link } from "react-router-dom";
import { MdLockOutline, MdOutlineAlternateEmail } from "react-icons/md";
import { Routes } from "../../types/RouteTypes";
import BaseModal from "./baseModal";

const Loginblury__modal = () => {
    return (
        <BaseModal>
            <h1 className="modal__title">Login</h1>
            <div className="modal__input">
                <div className="modal__input__item">
                    <MdOutlineAlternateEmail className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="email"
                        placeholder="Enter email"
                        name="email"
                        required
                    />
                </div>
                <div className="modal__input__item">
                    <MdLockOutline className="modal__input__item__icon" />
                    <input
                        className="modal__input__item__inputfield"
                        type="password"
                        name="pwd"
                        placeholder="Enter password"
                        required
                    />
                </div>
            </div>
            <button className="modal__btn">Login</button>
            <p className="modal__link">
                Don't have an account yet?{" "}
                <Link to={Routes.REGISTER}>Register</Link>
            </p>
        </BaseModal>
    );
};

export default Loginblury__modal;
