import { createContext, useState } from "react";
import { useLogoutMutation } from "../data/authenticationAPI";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
    const [logout] = useLogoutMutation();
    const [activeUser, setActiveUser] = useState();
    const [modal, setModal] = useState(null);
    const onClose = () => setModal(null);
    const handleLogout = async () => {
        const { data, error } = await logout();
        data && (localStorage.clear(), setModal(undefined));
    };

    return (
        <AppContext.Provider
            value={{
                activeUser,
                setActiveUser,
                modal,
                setModal,
                onClose,
            }}
        >
            {children}
        </AppContext.Provider>
    );
};

export default AppProvider;
