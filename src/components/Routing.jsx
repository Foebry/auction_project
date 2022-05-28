import { Routes, Route } from "react-router-dom";
import {
    INDEX,
    ADMIN,
    ADMIN_USERS,
    ADMIN_ARTICLES,
    ADMIN_AUCTIONS,
} from "../types/RouteTypes";
import Index from "../views/Index";
import Admin from "../views/admin/Admin";
import Users from "../views/admin/Users";
import Articles from "../views/admin/Articles";
import Auctions from "../views/admin/Articles";

const Routing = () => {
    return (
        <Routes>
            <Route path={INDEX} element={<Index />} />
            <Route path={ADMIN} element={<Admin />}>
                <Route index element={<Users />} />
                <Route path={ADMIN_USERS} element={<Users />} />
                <Route path={ADMIN_AUCTIONS} element={<Auctions />} />
                <Route path={ADMIN_ARTICLES} element={<Articles />} />
            </Route>
        </Routes>
    );
};

export default Routing;
