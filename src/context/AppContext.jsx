import { createContext, useState } from "react";
import { Navigate, useNavigate } from "react-router";
import { useLogoutMutation } from "../data/authenticationAPI";
import { INDEX } from "../types/RouteTypes";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
    const navigate = useNavigate();

    const [logout] = useLogoutMutation();
    const [activeUser, setActiveUser] = useState();
    const [modal, setModal] = useState(null);
    const onClose = () => setModal(null);
    const handleLogout = async () => {
        const { error } = await logout({});
        navigate(INDEX);
        if (!error) {
            localStorage.clear();
            window.location.reload();
        }
    };

    return (
        <AppContext.Provider
            value={{
                activeUser,
                setActiveUser,
                modal,
                setModal,
                onClose,
                handleLogout,
            }}
        >
            {children}
        </AppContext.Provider>
    );
};

export default AppProvider;
