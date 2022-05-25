import { createContext, useState } from "react";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
    const [activeUser, setActiveUser] = useState();
    const [modal, setModal] = useState(null);
    const onClose = () => setModal(null);

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
