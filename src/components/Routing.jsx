import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import AuctionDetail from "./AuctionDetail";
import Detailmodal from "./Detailmodal";
import Login from "./Login";
import Register from "./Register";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route path={views.AUCTION_DETAIL} element={<AuctionDetail />} />
            <Route path={views.LOGIN} element={<Login />} />
            <Route path={views.REGISTER} element={<Register />} />
            <Route path={views.DETAIL_MODAL} element={<Detailmodal />} />
        </Routes>
    );
};

export default Routing;
