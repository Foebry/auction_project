import React from "react";

const Login = () => {
    return (
        <>
            <form className="form">
                <h1 className="form__title">Login</h1>
                <div className="form__input">
                    <input
                        className="form__input__inputfield"
                        type="email"
                        placeholder="Enter email"
                        name="email"
                        required
                    />
                    <input
                        className="form__input__inputfield"
                        type="password"
                        name="pwd"
                        placeholder="Enter password"
                    />
                </div>
                <button className="form__btn">Login</button>
                <p className="form__goto">
                    Don't have an account yet? <a href="/register">Register</a>
                </p>
            </form>
        </>
    );
};

export default Login;
