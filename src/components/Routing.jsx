import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import Admin from "../views/Admin";
import Detailmodal from "./modals/Detailmodal";
import LoginModal from "./modals/LoginModal";
import RegisterModal from "./modals/RegisterModal";
import UserProductsModal from "./modals/UserProductsModal";
import UserModal from "./modals/UserModal";
import EditUserModal from "./modals/EditUserModal";
import AdminArticleModal from "./modals/AdminArticleModal";
import AdminAuctionModal from "./modals/AdminAuctionModal";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route path={views.ADMIN} element={<Admin />} />
            <Route path={views.LOGIN} element={<LoginModal />} />
            <Route path={views.REGISTER} element={<RegisterModal />} />
            <Route path={views.USER} element={<UserModal />} />
            <Route path={views.EDIT} element={<EditUserModal />} />
            <Route path={views.DETAIL_MODAL} element={<Detailmodal />} />
            <Route path={views.USER_PRODUCTS} element={<UserProductsModal />} />
            <Route
                path={views.ADMIN_ARTICLES}
                element={<AdminArticleModal />}
            />
            <Route
                path={views.ADMIN_AUCTIONS}
                element={<AdminAuctionModal />}
            />
        </Routes>
    );
};

export default Routing;
