import React from "react";
import { Link } from "react-router-dom";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";
import { Routes } from "../types/RouteTypes";

const Register = () => {
    const location = useLocation();

    const { state } = location;
    return (
        <>
            <form className="form" onSubmit={(e) => e.preventDefault()}>
                <h1 className="form__title">Register</h1>
                <div className="form__input">
                    <div>
                        <MdPersonOutline className="form__input__icon" />
                        <input
                            className="form__input__inputfield"
                            type="text"
                            placeholder="Enter first name"
                            name="firstname"
                            required
                        />
                    </div>
                    <div>
                        <MdPersonOutline className="form__input__icon2" />
                        <input
                            className="form__input__inputfield"
                            type="text"
                            placeholder="Enter name"
                            name="name"
                            required
                        />
                    </div>
                    <div>
                        <MdOutlineAlternateEmail className="form__input__icon" />
                        <input
                            className="form__input__inputfield"
                            type="email"
                            placeholder="Enter email"
                            name="email"
                            required
                        />
                    </div>
                    <div>
                        <MdLockOutline className="form__input__icon" />
                        <input
                            className="form__input__inputfield"
                            type="password"
                            name="pwd"
                            placeholder="Enter password"
                        />
                    </div>
                </div>
                <button className="form__btn">Sign Up</button>
                <p className="form__goto">
                    Already have an account? Go to{" "}
                    <Link to={Routes.LOGIN}>Login</Link>
                </p>
            </form>
        </>
    );
};

export default Register;
