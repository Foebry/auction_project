import React from "react";
import {
    MdLockOutline,
    MdOutlineAlternateEmail,
    MdPersonOutline,
} from "react-icons/md";

const Register = () => {
    return (
        <>
            <form className="form">
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
                    Already have an account? Go to <a href="/register">Login</a>
                </p>
            </form>
        </>
    );
};

export default Register;
