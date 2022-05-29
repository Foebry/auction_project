import { Navigate, Route, Routes } from "react-router";
import { NavLink } from "react-router-dom";
import {
    ADMIN_USERS,
    ADMIN_ARTICLES,
    ADMIN_AUCTIONS,
} from "../../types/RouteTypes";
import Users from "./Users";
import Articles from "./Articles";
import Auctions from "./Auctions";

const Admin = () => {
    return (
        <div className="container__medium admin">
            <nav>
                <ul className="admin__nav">
                    <li className="admin__nav__item">Admin</li>
                    <li className="admin__nav__item">
                        <NavLink
                            className="admin__nav__item__link"
                            to="/admin/users"
                        >
                            Users
                        </NavLink>
                    </li>
                    <li className="admin__nav__item">
                        <NavLink
                            className="admin__nav__item__link"
                            to={ADMIN_AUCTIONS}
                        >
                            Auctions
                        </NavLink>
                    </li>
                    <li className="admin__nav__item">
                        <NavLink
                            className="admin__nav__item__link"
                            to={ADMIN_ARTICLES}
                        >
                            Articles
                        </NavLink>
                    </li>
                </ul>
            </nav>
            <Routes>
                <Route index element={<Navigate to={ADMIN_USERS} />} />
                <Route path="users" element={<Users />} />
                <Route path="auctions" element={<Auctions />} />
                <Route path="articles" element={<Articles />} />
            </Routes>
        </div>
    );
};

export default Admin;
