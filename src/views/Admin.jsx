import React from "react";
import UserList from "../components/UserList";

const Admin = () => {
    return (
        <section className="container__medium admin">
            <ul className="admin__nav">
                <li className="admin__nav__item">Admin</li>
                <li className="admin__nav__item">
                    <button>Users</button>
                </li>
                <li className="admin__nav__item">
                    <button>Auctions</button>
                </li>
                <li className="admin__nav__item">
                    <button>Articles</button>
                </li>
            </ul>
            <UserList />
        </section>
    );
};

export default Admin;
