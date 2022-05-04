import { Account } from "../../types/Account"

const AccountCardComponent = ( { account }:Props ) => {


  return (
    <div className="bg-white rounded-md shadow-md shadow-indigo-400 text-black w-full mx-4 flex items-center justify-center">
      { account.name }
    </div>
  )
}

interface Props { 
  account: Account
}
export default AccountCardComponent