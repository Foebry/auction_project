import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import Detailmodal from "./modals/Detailmodal";
import LoginModal from "./modals/LoginModal";
import RegisterModal from "./modals/RegisterModal";
import UserProductsModal from "./modals/UserProductsModal";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route path={views.LOGIN} element={<LoginModal />} />
            <Route path={views.REGISTER} element={<RegisterModal />} />
            <Route path={views.DETAIL_MODAL} element={<Detailmodal />} />
            <Route path={views.USER_PRODUCTS} element={<UserProductsModal />} />
        </Routes>
    );
};

export default Routing;
