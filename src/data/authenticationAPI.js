import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const authenticationAPI = createApi({
    reducerPath: "authenticationState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        login: builder.mutation({
            query: ({ usr_email, usr_password, csrf, formkey }) => ({
                url: "/login",
                method: "POST",
                body: {
                    usr_email,
                    usr_password,
                    csrf,
                    formkey,
                },
            }),
        }),
        register: builder.mutation({
            query: ({
                usr_name,
                usr_lastname,
                usr_email,
                usr_password,
                csrf,
                formkey,
            }) => ({
                url: "/register",
                method: "POST",
                body: {
                    usr_name,
                    usr_lastname,
                    usr_email,
                    usr_password,
                    csrf,
                    formkey,
                },
            }),
        }),
        logout: builder.mutation({
            query: ({}) => ({
                url: "/logout",
                method: "DELETE",
            }),
        }),
    }),
});

export default authenticationAPI;
export const { useLoginMutation, useRegisterMutation, useLogoutMutation } =
    authenticationAPI;
