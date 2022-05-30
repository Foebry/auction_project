import { createContext, useState } from "react";
import { useNavigate } from "react-router";
import { useLogoutMutation } from "../data/authenticationAPI";
import { INDEX } from "../types/RouteTypes";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
    const navigate = useNavigate();
    const [updateAuction, setUpdateAuction] = useState(null);
    const [updateArticle, setUpdateArticle] = useState(null);
    const [updateUser, setUpdateUser] = useState(null);

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
                updateArticle,
                setUpdateArticle,
                updateAuction,
                setUpdateAuction,
                updateUser,
                setUpdateUser,
            }}
        >
            {children}
        </AppContext.Provider>
    );
};

export default AppProvider;
