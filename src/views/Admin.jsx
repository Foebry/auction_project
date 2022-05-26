import React, { useState } from "react";
import UserList from "../components/UserList";

const Admin = () => {
    const [contentShow, setContentShow] = useState("users");

    return (
        <section className="container__medium admin">
            <ul className="admin__nav">
                <li className="admin__nav__item">Admin</li>
                <li
                    className={
                        contentShow == "users"
                            ? `admin__nav__item admin__nav__item--active`
                            : `admin__nav__item`
                    }
                >
                    <button onClick={() => setContentShow("users")}>
                        Users
                    </button>
                </li>
                <li
                    className={
                        contentShow == "auctions"
                            ? `admin__nav__item admin__nav__item--active`
                            : `admin__nav__item`
                    }
                >
                    <button onClick={() => setContentShow("auctions")}>
                        Auctions
                    </button>
                </li>
                <li
                    className={
                        contentShow == "articles"
                            ? `admin__nav__item admin__nav__item--active`
                            : `admin__nav__item`
                    }
                >
                    <button onClick={() => setContentShow("articles")}>
                        Articles
                    </button>
                </li>
            </ul>
            {contentShow == "users" && <UserList />}
        </section>
    );
};

export default Admin;
