import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import AuctionDetail from "./AuctionDetail";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route path={views.AUCTION_DETAIL} element={<AuctionDetail />} />
        </Routes>
    );
};

export default Routing;
