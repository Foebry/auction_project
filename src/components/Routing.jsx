import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import AuctionDetail from "./AuctionDetail";
import Detailmodal from "./modals/Detailmodal";
import Login from "./Login";
import Register from "./Register";
import LoginModal from "./modals/LoginModal";
import RegisterModal from "./modals/RegisterModal";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route path={views.AUCTION_DETAIL} element={<AuctionDetail />} />
            <Route path={views.LOGIN} element={<LoginModal />} />
            <Route path={views.REGISTER} element={<RegisterModal />} />
            <Route path={views.DETAIL_MODAL} element={<Detailmodal />} />
        </Routes>
    );
};

export default Routing;
