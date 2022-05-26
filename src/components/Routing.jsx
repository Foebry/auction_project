import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import Detailmodal from "./modals/Detailmodal";
import LoginModal from "./modals/LoginModal";
import RegisterModal from "./modals/RegisterModal";
import UserModal from "./modals/UserModal";
import EditUserModal from "./modals/EditUserModal";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route path={views.LOGIN} element={<LoginModal />} />
            <Route path={views.REGISTER} element={<RegisterModal />} />
            <Route path={views.USER} element={<UserModal />} />
            <Route path={views.EDIT} element={<EditUserModal />} />
            <Route path={views.DETAIL_MODAL} element={<Detailmodal />} />
        </Routes>
    );
};

export default Routing;
