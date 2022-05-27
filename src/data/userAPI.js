import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const userAPI = createApi({
    reducerPath: "userState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getUsers: builder.query({
            query: () => "/users",
            providesTags: ["allUsers"],
        }),
        getCurrentUser: builder.query({
            query: () => "/user",
        }),
        getUserById: builder.query({
            query: (id) => `/user/${id}`,
        }),
        getUserAuctions: builder.query({
            query: () => "/user/auctions",
        }),
        getUserByIdAuctions: builder.query({
            query: (id) => `/user/${id}/auctions`,
        }),
        getUserBiddings: builder.query({
            query: () => "/user/biddings",
        }),
        getUserByIdBiddings: builder.query({
            query: (id) => `/user/${id}/biddings`,
        }),
        patchCurrentUser: builder.mutation({
            query: ({
                usr_name,
                usr_lastname,
                usr_email,
                usr_password,
                usr_pass_verify,
                csrf,
            }) => ({
                url: `/user`,
                method: "PATCH",
                body: {
                    usr_name,
                    usr_lastname,
                    usr_email,
                    usr_password,
                    usr_pass_verify,
                    csrf,
                },
            }),
            invalidatesTags: ["allUsers"],
        }),
        patchUserById: builder.mutation({
            query: ({
                usr_id,
                usr_name,
                usr_lastname,
                usr_email,
                usr_password,
                csrf,
            }) => ({
                url: `/user/${usr_id}`,
                method: "PATCH",
                body: {
                    usr_name,
                    usr_lastname,
                    usr_email,
                    usr_password,
                    csrf,
                },
            }),
            invalidatesTags: ["allUsers"],
        }),
        deleteUser: builder.mutation({
            query: (id, csrf) => ({
                url: `user/${id}`,
                body: {
                    csrf,
                },
            }),
            invalidatesTags: ["allUsers"],
        }),
    }),
});

export default userAPI;
export const {
    useGetUsersQuery,
    useGetCurrentUserQuery,
    useGetUserByIdQuery,
    useGetUserAuctionsQuery,
    useGetUserByIdAuctionsQuery,
    useGetUserBiddingsQuery,
    useGetUserByIdBiddingsQuery,
    usePatchCurrentUserMutation,
    usePatchUserByIdMutation,
    useDeleteUserMutation,
} = userAPI;
