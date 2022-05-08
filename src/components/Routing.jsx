import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import AuctionDetail from "./AuctionDetail";
import Login from "./Login";
import Register from "./Register";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route
                exact
                path={views.AUCTION_DETAIL}
                element={<AuctionDetail />}
            />
            <Route exact path={views.LOGIN} element={<Login />} />
            <Route exact path={views.REGISTER} element={<Register />} />
        </Routes>
    );
};

export default Routing;
