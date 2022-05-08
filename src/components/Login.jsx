import React from "react";
import { Link } from "react-router-dom";
import { MdLockOutline, MdOutlineAlternateEmail } from "react-icons/md";
import { Routes } from "../types/RouteTypes";

const Login = () => {
    return (
        <>
            <form className="form" onSubmit={(e) => e.preventDefault()}>
                <h1 className="form__title">Login</h1>
                <div className="form__input">
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
                            required
                        />
                    </div>
                </div>
                <button className="form__btn">Login</button>
                <p className="form__goto">
                    Don't have an account yet?{" "}
                    <Link to={Routes.REGISTER}>Register</Link>
                </p>
            </form>
        </>
    );
};

export default Login;
