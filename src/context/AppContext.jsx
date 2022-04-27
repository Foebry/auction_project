import { createContext, useState } from 'react';

export const AppContext = createContext();

const AppProvider = ({ children }) => {
  const [userId, setUserId] = useState();
  return (
    <AppContext.Provider
      value={{
        userId,
        setUserId,
      }}
    >
      {children}
    </AppContext.Provider>
  );
};

export default AppProvider;
