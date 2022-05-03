import { Routes, Route } from "react-router-dom";
import { Routes as views } from "../types/RouteTypes";
import Index from "../views/Index";
import Login from "./Login";

const Routing = () => {
    return (
        <Routes>
            <Route path={views.INDEX} element={<Index />} />
            <Route exact path={views.LOGIN} element={<Login />} />
        </Routes>
    );
};

export default Routing;
